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
            $total = $subtotal + $shipping;

            // Aplicar descuento si existe
            $discountAmount = 0;
            $appliedDiscount = Session::get('applied_discount');
            
            if ($appliedDiscount) {
                $discountAmount = $appliedDiscount['amount'];
                $total = max(0, $subtotal - $discountAmount);
            }

            // Obtener la dirección del usuario si existe
            $address = Auth::user()->address;

            return view('checkout', [
                'items' => $items,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $total,
                'address' => $address,
                'discountAmount' => $discountAmount,
                'appliedDiscount' => $appliedDiscount,
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
        // Validar los datos del formulario
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
            // Obtener el carrito
            $cart = ShoppingCart::where('user_id', Auth::id())->first();
            
            if (!$cart || $cart->items()->count() === 0) {
                return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío');
            }
    
            // Obtener los items
            $items = $cart->items()->with('product')->get();
    
            // Calcular el subtotal del pedido
            $subtotal = $items->sum(function($item) {
                return $item->product->price * $item->quantity;
            });

            $total = $subtotal;
            $discountAmount = 0;
            $appliedDiscountId = null;
            $discountCode = null;

            // Verificar si hay un descuento aplicado
            $appliedDiscount = Session::get('applied_discount');
            if ($appliedDiscount) {
                // Verificar que el descuento sigue siendo válido
                $discount = Discount::find($appliedDiscount['discount_id']);
                
                if ($discount && $discount->isValid()) {
                    $discountAmount = $appliedDiscount['amount'];
                    $total = max(0, $subtotal - $discountAmount);
                    $appliedDiscountId = $discount->id;
                    $discountCode = $discount->code;
                    
                    // Marcar el descuento como usado (incrementar contador)
                    $discount->increment('used');
                } else {
                    // El descuento ya no es válido, removerlo de la sesión
                    Session::forget('applied_discount');
                }
            }
    
            // Crear un nuevo pedido en la base de datos
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'discount_code' => $discountCode,
                'shipping_address' => $validated['address'],
                'shipping_city' => $validated['city'],
                'shipping_province' => $validated['province'],
                'shipping_zip' => $validated['zip'],
                'shipping_phone' => $validated['phone'],
                'full_name' => $validated['firstName'] . ' ' . $validated['lastName'],
                'payment_method' => 'stripe',
                'status' => 'pending'
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
    
            // Limpiar sesión de descuento
            Session::forget(['applied_discount', 'checkout_discount_total', 'checkout_discount_code']);
    
            // IMPORTANTE: Añadir log para depuración
            Log::info('Redirigiendo a pasarela de pago con order_id: ' . $order->id);
    
            // Para la integración con Stripe, redirigimos a Stripe
            return redirect()->route('payment.stripe.checkout');
            
        } catch (\Exception $e) {
            // Log del error para depuración
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