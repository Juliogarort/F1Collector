<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartItem;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        // Cargar el pedido con todas las relaciones necesarias
        $order = Order::with([
            'items.product', 
            'items.product.team'
        ])->findOrFail($orderId);

        try {
            // Crear los line_items para la sesión de Stripe
            $lineItems = [];

            foreach ($order->items as $item) {
                // Asegurarse de que el producto existe
                if (!$item->product) {
                    continue;
                }

                // Preparar datos del producto para Stripe
                $productData = [
                    'name' => $item->product->name,
                    'description' => $item->product->team ? $item->product->team->name : '',
                ];

                // Preparar la URL de la imagen con verificación
                if (!empty($item->product->image)) {
                    // Asegúrate de que la URL sea absoluta, accesible, y con HTTPS
                    $imageUrl = asset($item->product->image);
                    
                    // Para entornos de desarrollo podríamos necesitar una URL pública
                    // Si estás en desarrollo local, considera usar un servicio como ngrok
                    // o subir las imágenes a un CDN o servicio de almacenamiento público
                    
                    // Si la URL no comienza con https, forzarla 
                    // (solo haz esto si tu sitio tiene certificado SSL)
                    if (strpos($imageUrl, 'https://') !== 0 && app()->environment('production')) {
                        $imageUrl = str_replace('http://', 'https://', $imageUrl);
                    }
                    
                    // Agregar la imagen a los datos del producto
                    $productData['images'] = [$imageUrl];
                    
                    // Log para depuración
                    Log::info('Imagen para Stripe: ' . $imageUrl);
                }

                // Agregar el item a los line_items de Stripe
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => $productData,
                        'unit_amount' => (int)($item->price * 100), // Asegurar que sea un entero
                    ],
                    'quantity' => $item->quantity,
                ];
            }

            // Validar que tengamos items para procesar
            if (empty($lineItems)) {
                return redirect()->route('cart.index')->with('error', 'No hay productos válidos en el carrito');
            }

            // Log para depuración
            Log::info('Stripe line items: ' . json_encode($lineItems));

            // Crear la sesión de Stripe Checkout
            $stripeSession = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('payment.failed'),
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
            // Log para depuración
            Log::error('Error de Stripe: ' . $e->getMessage());
            
            // Manejo de errores de la API de Stripe
            return redirect()->route('payment.failed')->with('error', 'Error al procesar el pago: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Log para depuración
            Log::error('Error general: ' . $e->getMessage());
            
            // Manejo de otros errores
            return redirect()->route('payment.failed')->with('error', 'Error al procesar la solicitud: ' . $e->getMessage());
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
                $payload,
                $sigHeader,
                $endpointSecret
            );

            // Log para depuración
            Log::info('Evento de Stripe recibido: ' . $event->type);

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
                    
                    // Log para depuración
                    Log::info('Pedido #' . $order->id . ' actualizado a estado: paid');

                    // Eliminar los elementos del carrito
                    $this->clearCart($order->user_id);

                    // Aquí puedes añadir lógica adicional, como enviar correos, etc.
                } else {
                    // Log para depuración
                    Log::warning('No se encontró un pedido con payment_id: ' . $session->id);
                }
            }

            return response()->json(['status' => 'success']);
        } catch (\UnexpectedValueException $e) {
            // Log para depuración
            Log::error('Error de firma inválida: ' . $e->getMessage());
            
            // Firma inválida
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Log para depuración
            Log::error('Error de verificación de firma: ' . $e->getMessage());
            
            // Firma inválida
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\Exception $e) {
            // Log para depuración
            Log::error('Error en webhook: ' . $e->getMessage());
            
            // Error general
            return response()->json(['error' => 'Error processing webhook'], 500);
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
            $order = Order::with([
                'items.product', 
                'items.product.team'
            ])->where('payment_id', $sessionId)->first();
            
            if (!$order) {
                // Log para depuración
                Log::warning('No se encontró un pedido con payment_id: ' . $sessionId);
                
                return redirect()->route('home')->with('error', 'No se encontró el pedido');
            }
            
            // Si el webhook no ha actualizado el pedido todavía, actualizarlo aquí
            if ($order->status !== 'paid' && $session->payment_status === 'paid') {
                $order->status = 'paid';
                $order->payment_date = now();
                $order->save();
                
                // Log para depuración
                Log::info('Pedido #' . $order->id . ' actualizado a estado: paid (desde página de éxito)');
                
                // Eliminar los elementos del carrito
                $this->clearCart($order->user_id);
                
                // Limpiar la sesión
                Session::forget('cart');
                Session::forget('order_id');
            }
            
            return view('payment.success', compact('order'));
        } catch (ApiErrorException $e) {
            // Log para depuración
            Log::error('Error de Stripe en página de éxito: ' . $e->getMessage());
            
            return redirect()->route('payment.failed')->with('error', 'Error al verificar el pago: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Log para depuración
            Log::error('Error en página de éxito: ' . $e->getMessage());
            
            return redirect()->route('payment.failed')->with('error', 'Error al procesar la solicitud: ' . $e->getMessage());
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
        
        try {
            $order = Order::with([
                'items.product', 
                'items.product.team'
            ])->findOrFail($orderId);
            
            // Marcar el pedido como fallido si no está pagado
            if ($order->status === 'pending') {
                $order->status = 'failed';
                $order->save();
                
                // Log para depuración
                Log::info('Pedido #' . $order->id . ' actualizado a estado: failed');
            }
            
            return view('payment.failed', compact('order'));
        } catch (\Exception $e) {
            // Log para depuración
            Log::error('Error en página de fallo: ' . $e->getMessage());
            
            return redirect()->route('home')->with('error', 'Error al cargar el pedido: ' . $e->getMessage());
        }
    }

    /**
     * Método privado para vaciar el carrito de un usuario
     */
    private function clearCart($userId)
    {
        try {
            // Obtener el carrito del usuario
            $cart = ShoppingCart::where('user_id', $userId)->first();
            
            if ($cart) {
                // Eliminar todos los elementos del carrito
                ShoppingCartItem::where('shopping_cart_id', $cart->id)->delete();
                
                // Log para depuración
                Log::info('Carrito del usuario #' . $userId . ' vaciado correctamente');
                
                return true;
            }
            
            return false;
        } catch (\Exception $e) {
            // Log para depuración
            Log::error('Error al vaciar el carrito: ' . $e->getMessage());
            
            return false;
        }
    }
}