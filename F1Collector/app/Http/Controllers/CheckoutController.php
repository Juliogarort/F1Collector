<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Discount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\ShoppingCart;
use Illuminate\Support\Facades\Log;

use Illuminate\Routing\Controller;

class CheckoutController extends Controller
{
    /**
     * Constructor para aplicar middleware de autenticación
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la página de checkout con los items del carrito
     */
    public function index()
    {
        try {
            $cart = ShoppingCart::where('user_id', Auth::id())->first();
            
            if (!$cart || $cart->items()->count() === 0) {
                return redirect()->route('catalogo')->with('error', 'Tu carrito está vacío');
            }

            // Obtener los items del carrito
            $items = $cart->items()->with('product')->get();

            // Calcular subtotal
            $subtotal = $items->sum(function($item) {
                return $item->product->price * $item->quantity;
            });
            
            $shipping = 0; // Envío gratis por ahora

            // Aplicar descuento si existe
            $discountAmount = 0;
            $appliedDiscount = Session::get('applied_discount');
            
            if ($appliedDiscount) {
                $discountAmount = $appliedDiscount['amount'];
            }

            $total = max(0, $subtotal + $shipping - $discountAmount);

            // Obtener la dirección del usuario si existe
            $address = Auth::user()->address;

            // ✨ OBTENER CUPONES DISPONIBLES (solo si no hay descuento aplicado)
            $availableCoupons = collect();
            $bestCoupon = null;
            
            if (!$appliedDiscount) {
                try {
                    $availableCoupons = Discount::where(function($query) {
                        $query->where('expires_at', '>', now())
                              ->orWhereNull('expires_at');
                    })
                    ->where(function($query) {
                        $query->whereNull('usage_limit')
                              ->orWhereRaw('used < usage_limit');
                    })
                    ->orderBy('discount_percentage', 'desc')
                    ->orderBy('discount_amount', 'desc')
                    ->limit(3)
                    ->get();

                    $bestCoupon = Discount::where(function($query) {
                        $query->where('expires_at', '>', now())
                              ->orWhereNull('expires_at');
                    })
                    ->where(function($query) {
                        $query->whereNull('usage_limit')
                              ->orWhereRaw('used < usage_limit');
                    })
                    ->orderByRaw('CASE 
                        WHEN discount_percentage IS NOT NULL THEN discount_percentage 
                        WHEN discount_amount IS NOT NULL THEN discount_amount * 2
                        ELSE 0 
                    END DESC')
                    ->first();
                } catch (\Exception $e) {
                    Log::warning('Error obteniendo cupones: ' . $e->getMessage());
                }
            }

            return view('checkout', [
                'items' => $items,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $total,
                'address' => $address,
                'discountAmount' => $discountAmount,
                'appliedDiscount' => $appliedDiscount,
                'availableCoupons' => $availableCoupons,  // ← Nuevo
                'bestCoupon' => $bestCoupon,              // ← Nuevo
            ]);

        } catch (\Exception $e) {
            Log::error('Error en checkout: ' . $e->getMessage());
            return redirect()->route('catalogo')->with('error', 'Error al cargar el checkout');
        }
    }

    /**
     * Procesa los datos del formulario de checkout
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'zip' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
        ]);
    
        try {
            $cart = ShoppingCart::where('user_id', Auth::id())->first();
            
            if (!$cart || $cart->items()->count() === 0) {
                return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío');
            }

            $items = $cart->items()->with('product')->get();
            $subtotal = $items->sum(fn($item) => $item->product->price * $item->quantity);

            // ✨ APLICAR DESCUENTO AL TOTAL
            $discountAmount = 0;
            $appliedDiscount = Session::get('applied_discount');
            $discountCode = null;
            
            if ($appliedDiscount) {
                $discountAmount = $appliedDiscount['amount'];
                $discountCode = $appliedDiscount['code'];
                
                // Marcar el descuento como usado
                try {
                    $discount = Discount::find($appliedDiscount['discount_id']);
                    if ($discount) {
                        $discount->markAsUsed();
                    }
                } catch (\Exception $e) {
                    Log::warning('Error marcando descuento como usado: ' . $e->getMessage());
                }
            }

            $total = max(0, $subtotal - $discountAmount);

            // Crear el pedido
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'subtotal' => $subtotal,                    // ← Nuevo
                'discount_amount' => $discountAmount,       // ← Nuevo
                'discount_code' => $discountCode,           // ← Nuevo
                'shipping_address' => $validated['address'],
                'shipping_city' => $validated['city'],
                'shipping_province' => $validated['province'],
                'shipping_zip' => $validated['zip'],
                'shipping_phone' => $validated['phone'],
                'full_name' => $validated['firstName'] . ' ' . $validated['lastName'],
                'payment_method' => 'stripe',
                'status' => 'pending',
            ]);

            // Guardar los items del pedido
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);
            }

            // Guardar el ID del pedido en la sesión
            Session::put('order_id', $order->id);

            // ✨ LIMPIAR DESCUENTO DE LA SESIÓN
            Session::forget('applied_discount');

            Log::info('Redirigiendo a pasarela de pago con order_id: ' . $order->id);

            return redirect()->route('payment.stripe.checkout');
            
        } catch (\Exception $e) {
            Log::error('Error al procesar checkout: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al procesar el pedido: ' . $e->getMessage());
        }
    }

    /**
     * Ver todos los pedidos del usuario
     */
    public function ordersIndex()
    {
        $orders = Order::where('user_id', Auth::id())
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);
        
        return view('orders.index', compact('orders'));
    }

    /**
     * Ver detalles de un pedido específico
     */
    public function show(Order $order)
    {
        // Verificar que el pedido pertenece al usuario autenticado
        if ($order->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para ver este pedido');
        }
        
        $order->load('items.product');
        
        return view('orders.show', compact('order'));
    }
}