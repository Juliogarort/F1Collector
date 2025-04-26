<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Auth;

use Illuminate\Routing\Controller;

class PaymentController extends Controller
{
    /**
     * Constructor para aplicar middleware de autenticación
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['stripeWebhook']]);
        // Configurar la clave secreta de Stripe
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Procesar pago con Stripe
     */
    public function stripeCheckout()
    {
        $orderId = Session::get('order_id');
        
        if (!$orderId) {
            return redirect()->route('cart.index')->with('error', 'No se encontró ningún pedido');
        }

        $order = Order::with('items.product')->findOrFail($orderId);

        try {
            // Crear los line_items para la sesión de Stripe
            $lineItems = [];
            
            foreach ($order->items as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $item->product->name,
                            'description' => $item->product->team ?? '',
                            'images' => [url($item->product->image)],
                        ],
                        'unit_amount' => $item->price * 100, // Stripe requiere el precio en centavos
                    ],
                    'quantity' => $item->quantity,
                ];
            }

            // Crear la sesión de Stripe Checkout
            $stripeSession = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'customer_email' => Auth::user()->email,
                'customer_email' => Auth::user()->email,
                'client_reference_id' => $order->id,
                'metadata' => [
                    'order_id' => $order->id,
                ],
            ]);

            // Actualizar el pedido con el ID de sesión de Stripe
            $order->payment_id = $stripeSession->id;
            $order->save();

            // Redirigir al usuario a la página de pago de Stripe
            return view('payment.stripe-redirect', [
                'stripeSession' => $stripeSession,
                'order' => $order,
            ]);

        } catch (ApiErrorException $e) {
            // Manejo de errores de la API de Stripe
            return redirect()->route('payment.failed')->with('error', $e->getMessage());
        }
    }

    /**
     * Webhook para recibir notificaciones de Stripe
     */
    public function stripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');
        
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
            
            // Manejar el evento
            if ($event->type == 'checkout.session.completed') {
                $session = $event->data->object;
                
                // Buscar el pedido por el ID de sesión de Stripe
                $order = Order::where('payment_id', $session->id)->first();
                
                if ($order) {
                    // Actualizar el estado del pedido
                    $order->status = 'paid';
                    $order->payment_date = now();
                    $order->save();
                    
                    // Aquí puedes añadir lógica adicional, como enviar correos, etc.
                }
            }
            
            return response()->json(['status' => 'success']);
            
        } catch (\UnexpectedValueException $e) {
            // Firma inválida
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Firma inválida
            return response()->json(['error' => 'Invalid signature'], 400);
        }
    }

    /**
     * Página de pago exitoso
     */
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        
        if (!$sessionId) {
            return redirect()->route('home');
        }
        
        try {
            // Verificar la sesión de Stripe
            $session = StripeSession::retrieve($sessionId);
            
            // Buscar el pedido por el ID de sesión
            $order = Order::where('payment_id', $sessionId)->first();
            
            if (!$order) {
                return redirect()->route('home')->with('error', 'No se encontró el pedido');
            }
            
            // Si el webhook no ha actualizado el pedido todavía, actualizarlo aquí
            if ($order->status !== 'paid' && $session->payment_status === 'paid') {
                $order->status = 'paid';
                $order->payment_date = now();
                $order->save();
                
                // Limpiar el carrito
                Session::forget('cart');
                Session::forget('order_id');
            }
            
            return view('payment.success', compact('order'));
            
        } catch (ApiErrorException $e) {
            return redirect()->route('payment.failed')->with('error', $e->getMessage());
        }
    }

    /**
     * Página de pago fallido
     */
    public function failed()
    {
        $orderId = Session::get('order_id');
        
        if (!$orderId) {
            return redirect()->route('home');
        }
        
        $order = Order::findOrFail($orderId);
        
        // Marcar el pedido como fallido si no está pagado
        if ($order->status === 'pending') {
            $order->status = 'failed';
            $order->save();
        }
        
        return view('payment.failed', compact('order'));
    }
}