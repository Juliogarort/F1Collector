<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener usuarios de tipo Customer
        $customerUsers = User::where('user_type', 'Customer')->pluck('id')->toArray();
        
        // Definir posibles estados de pedidos
        $statuses = ['pending', 'paid', 'processing', 'shipped', 'delivered', 'cancelled'];
        
        // Definir fechas para distribuir pedidos en los últimos 6 meses
        $startDate = Carbon::now()->subMonths(6);
        $endDate = Carbon::now();
        
        // Crear 50 pedidos con fechas distribuidas
        for ($i = 0; $i < 50; $i++) {
            // Elegir un usuario aleatorio de tipo Customer
            $userId = $customerUsers[array_rand($customerUsers)];
            
            // Generar una fecha aleatoria entre startDate y endDate
            $orderDate = Carbon::createFromTimestamp(
                rand($startDate->timestamp, $endDate->timestamp)
            );
            
            // Asignar un estado aleatorio con mayor probabilidad para 'paid' y 'delivered'
            $statusWeights = [
                'pending' => 10,
                'paid' => 25,
                'processing' => 15,
                'shipped' => 15,
                'delivered' => 25,
                'cancelled' => 10,
            ];
            
            $status = $this->getRandomWeightedElement($statusWeights);
            
            // Crear el pedido
            $order = Order::create([
                'user_id' => $userId,
                'total' => 0, // Se actualizará después de añadir productos
                'shipping_address' => 'Calle Ejemplo ' . rand(1, 100),
                'shipping_city' => $this->getRandomCity(),
                'shipping_province' => $this->getRandomProvince(),
                'shipping_zip' => rand(10000, 99999),
                'shipping_phone' => '6' . rand(10000000, 99999999),
                'full_name' => User::find($userId)->name,
                'payment_method' => rand(1, 10) > 2 ? 'stripe' : 'paypal',
                'status' => $status,
                'created_at' => $orderDate,
                'updated_at' => $orderDate
            ]);
            
            // Si el pedido está pagado, añadir fecha de pago
            if (in_array($status, ['paid', 'processing', 'shipped', 'delivered'])) {
                $paymentDate = clone $orderDate;
                $paymentDate->addMinutes(rand(5, 60)); // Pago entre 5 y 60 minutos después
                
                $order->payment_id = 'ch_' . $this->generateRandomString(24);
                $order->payment_date = $paymentDate;
                $order->save();
            }
            
            // Ahora llamaremos al OrderItemSeeder para añadir los items a esta orden
            $this->seedOrderItems($order);
        }
    }
    
    private function seedOrderItems($order)
    {
        // Obtener todos los productos
        $products = Product::all();
        
        // Determinar cuántos productos diferentes tendrá este pedido (entre 1 y 3)
        $numberOfProducts = rand(1, 3);
        
        // Total del pedido
        $orderTotal = 0;
        
        // Seleccionar productos aleatorios
        $selectedProducts = $products->random($numberOfProducts);
        
        foreach ($selectedProducts as $product) {
            // Determinar cantidad (entre 1 y 3 unidades)
            $quantity = rand(1, 3);
            
            // Calcular subtotal para este item
            $itemTotal = $product->price * $quantity;
            $orderTotal += $itemTotal;
            
            // Crear el item de pedido
            DB::table('f1collector_order_items')->insert([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
                'created_at' => $order->created_at,
                'updated_at' => $order->created_at
            ]);
        }
        
        // Actualizar el total del pedido
        $order->total = $orderTotal;
        $order->save();
    }
    
    private function getRandomCity()
    {
        $cities = ['Madrid', 'Barcelona', 'Valencia', 'Sevilla', 'Zaragoza', 'Málaga', 'Murcia', 'Palma', 'Bilbao', 'Alicante'];
        return $cities[array_rand($cities)];
    }
    
    private function getRandomProvince()
    {
        $provinces = ['Madrid', 'Barcelona', 'Valencia', 'Sevilla', 'Zaragoza', 'Málaga', 'Murcia', 'Islas Baleares', 'Vizcaya', 'Alicante'];
        return $provinces[array_rand($provinces)];
    }
    
    private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    private function getRandomWeightedElement(array $weightedValues)
    {
        $rand = rand(1, array_sum($weightedValues));
        
        foreach ($weightedValues as $key => $value) {
            $rand -= $value;
            if ($rand <= 0) {
                return $key;
            }
        }
    }
}