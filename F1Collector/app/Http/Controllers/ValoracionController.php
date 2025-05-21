<?php
// app/Http/Controllers/ValoracionController.php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Valoracion;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Routing\Controller as BaseController;

class ValoracionController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Mostrar formulario de valoración
    public function create(Product $product)
    {
        // Verificar si el usuario ha comprado el producto
        $haComprado = OrderItem::whereHas('order', function ($query) {
            $query->where('user_id', Auth::id())
                  ->where('status', 'paid'); // o 'delivered' según tu modelo de negocio
        })->where('product_id', $product->id)->exists();
        
        if (!$haComprado) {
            return redirect()->route('catalogo')
                ->with('error', 'Solo puedes valorar productos que hayas comprado.');
        }
        
        // Verificar si ya ha valorado este producto
        if (Auth::user()->haValorado($product)) {
            return redirect()->route('catalogo')
                ->with('error', 'Ya has valorado este producto anteriormente.');
        }
        
        return view('valoraciones.create', compact('product'));
    }

    // Guardar valoración
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000',
        ]);
        
        // Verificar si el usuario ha comprado el producto
        $orderItem = OrderItem::whereHas('order', function ($query) {
            $query->where('user_id', Auth::id())
                  ->whereIn('status', ['paid', 'delivered']);
        })->where('product_id', $product->id)->first();
        
        if (!$orderItem) {
            return redirect()->route('catalogo')
                ->with('error', 'Solo puedes valorar productos que hayas comprado.');
        }
        
        // Crear la valoración
        Valoracion::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'order_id' => $orderItem->order_id,
            'puntuacion' => $request->puntuacion,
            'comentario' => $request->comentario,
            'compra_verificada' => true,
            'aprobada' => true  // O false si quieres moderación
        ]);
        
        return redirect()->route('catalogo')
            ->with('success', '¡Gracias por tu valoración!');
    }
    
    // Mostrar productos disponibles para valorar
    public function productosParaValorar()
    {
        // Obtener pedidos del usuario que estén pagados o entregados
        $pedidos = Order::where('user_id', Auth::id())
                        ->whereIn('status', ['paid', 'delivered'])
                        ->with('items.product')
                        ->get();
        
        $productosValorados = Auth::user()->valoraciones()->pluck('product_id')->toArray();
        
        $productosParaValorar = [];
        
        foreach ($pedidos as $pedido) {
            foreach ($pedido->items as $item) {
                // Si el producto no ha sido valorado aún, añadirlo a la lista
                if (!in_array($item->product_id, $productosValorados)) {
                    $productosParaValorar[] = $item->product;
                }
            }
        }
        
        // Eliminar duplicados
        $productosParaValorar = collect($productosParaValorar)->unique('id')->values();
        
        return view('valoraciones.productos_para_valorar', compact('productosParaValorar'));
    }
}