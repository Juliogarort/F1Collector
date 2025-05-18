<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Mostrar panel de analíticas
     */
    public function index()
    {
        // Estadísticas generales
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        
        // Ingresos de pedidos pagados
        $paidRevenue = Order::where('status', 'paid')->sum('total');
        
        // Ingresos totales (todos los pedidos completados: paid, processing, shipped, delivered)
        $totalRevenue = Order::whereIn('status', ['paid', 'processing', 'shipped', 'delivered'])->sum('total');
        
        // Desglose de ingresos por estado de pedido
        $revenueByStatus = Order::select('status', DB::raw('SUM(total) as total_amount'), DB::raw('COUNT(*) as order_count'))
            ->groupBy('status')
            ->get()
            ->keyBy('status');
        
        // Obtener datos para los gráficos y tablas
        $newUsersData = $this->getNewUsersPerMonth();
        $revenueData = $this->getRevenuePerMonth();
        $topProducts = $this->getTopSellingProducts();
        $orderStatusDistribution = $this->getOrderStatusDistribution();
        
        return view('admin.analytics', compact(
            'totalUsers', 
            'totalProducts', 
            'totalOrders', 
            'paidRevenue',
            'totalRevenue',
            'revenueByStatus',
            'newUsersData',
            'revenueData',
            'topProducts',
            'orderStatusDistribution'
        ));
    }
    
    /**
     * Obtener datos de nuevos usuarios por mes
     */
    private function getNewUsersPerMonth()
    {
        $sixMonthsAgo = Carbon::now()->subMonths(6);
        
        $usersPerMonth = User::select(
                DB::raw('MONTH(created_at) as month'), 
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', $sixMonthsAgo)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
        
        // Formatear datos para la gráfica
        $labels = [];
        $data = [];
        
        // Crear array con los últimos 6 meses
        for ($i = 0; $i < 6; $i++) {
            $date = Carbon::now()->subMonths(5 - $i);
            $monthKey = $date->format('n-Y');
            $labels[] = $date->format('M Y');
            $data[$monthKey] = 0;
        }
        
        // Llenar con datos reales
        foreach ($usersPerMonth as $item) {
            $monthKey = $item->month . '-' . $item->year;
            if (isset($data[$monthKey])) {
                $data[$monthKey] = $item->total;
            }
        }
        
        return [
            'labels' => $labels,
            'data' => array_values($data)
        ];
    }
    
    /**
     * Obtener datos de ingresos por mes
     */
    private function getRevenuePerMonth()
    {
        $sixMonthsAgo = Carbon::now()->subMonths(6);
        
        $revenuePerMonth = Order::select(
                DB::raw('MONTH(created_at) as month'), 
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total) as total')
            )
            ->whereIn('status', ['paid', 'processing', 'shipped', 'delivered']) // Include all completed statuses
            ->where('created_at', '>=', $sixMonthsAgo)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
        
        // Formatear datos para la gráfica
        $labels = [];
        $data = [];
        
        // Crear array con los últimos 6 meses
        for ($i = 0; $i < 6; $i++) {
            $date = Carbon::now()->subMonths(5 - $i);
            $monthKey = $date->format('n-Y');
            $labels[] = $date->format('M Y');
            $data[$monthKey] = 0;
        }
        
        // Llenar con datos reales
        foreach ($revenuePerMonth as $item) {
            $monthKey = $item->month . '-' . $item->year;
            if (isset($data[$monthKey])) {
                $data[$monthKey] = (float) $item->total; // Ensure float for accurate rendering
            }
        }
        
        return [
            'labels' => $labels,
            'data' => array_values($data)
        ];
    }
    
    /**
     * Obtener productos más vendidos
     */
    private function getTopSellingProducts($limit = 5)
    {
        return OrderItem::select(
                'product_id',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('SUM(quantity * price) as total_revenue')
            )
            ->with('product')
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'desc')
            ->limit($limit)
            ->get();
    }
    
    /**
     * Obtener distribución de pedidos por estado
     */
    private function getOrderStatusDistribution()
    {
        $orderStatusCounts = Order::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();
        
        $labels = [];
        $data = [];
        $backgroundColor = [
            'pending' => '#ffc107',    // Amarillo
            'paid' => '#28a745',       // Verde
            'processing' => '#17a2b8', // Azul claro
            'shipped' => '#007bff',    // Azul
            'delivered' => '#20c997',  // Turquesa
            'failed' => '#dc3545',     // Rojo
            'cancelled' => '#6c757d',  // Gris
        ];
        $colors = [];
        
        foreach ($orderStatusCounts as $status) {
            $labels[] = ucfirst($status->status); // Capitalizar primera letra
            $data[] = $status->total;
            $colors[] = $backgroundColor[$status->status] ?? '#6c757d';
        }
        
        return [
            'labels' => $labels,
            'data' => $data,
            'backgroundColor' => $colors
        ];
    }
}