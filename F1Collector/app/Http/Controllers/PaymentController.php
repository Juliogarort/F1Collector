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
use Illuminate\Support\Facades\Mail;
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
            // ✨ CREAR LINE ITEMS CONSIDERANDO EL DESCUENTO
            $lineItems = [];

            // Si hay descuento aplicado, crear un solo line item con el total final
            if ($order->hasDiscount()) {
                Log::info('Pedido con descuento detectado:', [
                    'order_id' => $order->id,
                    'subtotal' => $order->subtotal,
                    'discount_amount' => $order->discount_amount,
                    'discount_code' => $order->discount_code,
                    'total' => $order->total
                ]);

                // Crear un line item único con el total final
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Pedido F1Collector #' . $order->id,
                            'description' => 'Pedido con descuento aplicado (' . $order->discount_code . ') - Ahorro: €' . number_format($order->discount_amount, 2),
                        ],
                        'unit_amount' => (int)($order->total * 100), // Usar el total con descuento
                    ],
                    'quantity' => 1,
                ];
            } else {
                // Sin descuento: crear line items individuales por producto (comportamiento original)
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
                        $imageUrl = asset($item->product->image);
                        
                        if (strpos($imageUrl, 'https://') !== 0 && app()->environment('production')) {
                            $imageUrl = str_replace('http://', 'https://', $imageUrl);
                        }
                        
                        $productData['images'] = [$imageUrl];
                        Log::info('Imagen para Stripe: ' . $imageUrl);
                    }

                    // Agregar el item a los line_items de Stripe
                    $lineItems[] = [
                        'price_data' => [
                            'currency' => 'eur',
                            'product_data' => $productData,
                            'unit_amount' => (int)($item->price * 100),
                        ],
                        'quantity' => $item->quantity,
                    ];
                }
            }

            // Validar que tengamos items para procesar
            if (empty($lineItems)) {
                return redirect()->route('cart.index')->with('error', 'No hay productos válidos en el carrito');
            }

            // Log para depuración
            Log::info('Stripe checkout iniciado:', [
                'order_id' => $order->id,
                'has_discount' => $order->hasDiscount(),
                'total_amount' => $order->total,
                'line_items_count' => count($lineItems),
                'discount_info' => $order->hasDiscount() ? [
                    'code' => $order->discount_code,
                    'amount' => $order->discount_amount
                ] : null
            ]);

            // ✨ PREPARAR DATOS PARA LA SESIÓN DE STRIPE
            $sessionData = [
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('payment.failed'),
                'customer_email' => Auth::user()->email,
                'client_reference_id' => $order->id,
                'metadata' => [
                    'order_id' => $order->id,
                    'user_id' => Auth::id(),
                ],
            ];

            // ✨ Si hay descuento, agregarlo a los metadatos
            if ($order->hasDiscount()) {
                $sessionData['metadata']['discount_code'] = $order->discount_code;
                $sessionData['metadata']['discount_amount'] = $order->discount_amount;
                $sessionData['metadata']['original_subtotal'] = $order->subtotal;
                $sessionData['metadata']['has_discount'] = 'true';
            } else {
                $sessionData['metadata']['has_discount'] = 'false';
            }

            // Crear la sesión de Stripe Checkout
            $stripeSession = StripeSession::create($sessionData);

            // Actualizar el pedido con el ID de sesión de Stripe
            $order->payment_id = $stripeSession->id;
            $order->save();

            Log::info('Sesión de Stripe creada exitosamente:', [
                'session_id' => $stripeSession->id,
                'order_id' => $order->id,
                'amount_total' => $stripeSession->amount_total ?? 'N/A'
            ]);

            // Redirigir al usuario a la página de pago de Stripe
            return view('payment.stripe-redirect', [
                'stripeSession' => $stripeSession,
                'order' => $order,
            ]);
        } catch (ApiErrorException $e) {
            Log::error('Error de Stripe API:', [
                'message' => $e->getMessage(),
                'order_id' => $order->id ?? 'N/A'
            ]);
            
            return redirect()->route('payment.failed')->with('error', 'Error al procesar el pago: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Error general en stripe checkout:', [
                'message' => $e->getMessage(),
                'order_id' => $order->id ?? 'N/A',
                'trace' => $e->getTraceAsString()
            ]);
            
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
                    
                    // ✨ Log mejorado con información de descuento
                    Log::info('Pedido completado exitosamente:', [
                        'order_id' => $order->id,
                        'status' => 'paid',
                        'total_paid' => $order->total,
                        'has_discount' => $order->hasDiscount(),
                        'discount_code' => $order->discount_code,
                        'discount_amount' => $order->discount_amount,
                        'session_id' => $session->id
                    ]);

                    // Eliminar los elementos del carrito
                    $this->clearCart($order->user_id);

                    // Enviar email de confirmación si está configurado
                    try {
                        if (class_exists('\App\Mail\OrderInvoiceMail')) {
                            Mail::to($order->user->email)->send(new \App\Mail\OrderInvoiceMail($order));
                            Log::info('Email de confirmación enviado para pedido #' . $order->id);
                        }
                    } catch (\Exception $mailException) {
                        Log::warning('Error enviando email de confirmación: ' . $mailException->getMessage());
                    }
                } else {
                    Log::warning('No se encontró un pedido con payment_id: ' . $session->id);
                }
            }

            return response()->json(['status' => 'success']);
        } catch (\UnexpectedValueException $e) {
            Log::error('Error de firma inválida en webhook: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Error de verificación de firma en webhook: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\Exception $e) {
            Log::error('Error general en webhook: ' . $e->getMessage());
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
                Log::warning('No se encontró un pedido con payment_id: ' . $sessionId);
                return redirect()->route('home')->with('error', 'No se encontró el pedido');
            }
            
            // Si el webhook no ha actualizado el pedido todavía, actualizarlo aquí
            if ($order->status !== 'paid' && $session->payment_status === 'paid') {
                $order->status = 'paid';
                $order->payment_date = now();
                $order->save();

                // ✨ Log con información de descuento
                Log::info('Pedido actualizado desde página de éxito:', [
                    'order_id' => $order->id,
                    'total_paid' => $order->total,
                    'has_discount' => $order->hasDiscount(),
                    'discount_savings' => $order->discount_amount ?? 0
                ]);

                // Enviar email de confirmación
                try {
                    if (class_exists('\App\Mail\OrderInvoiceMail')) {
                        Mail::to($order->user->email)->send(new \App\Mail\OrderInvoiceMail($order));
                    }
                } catch (\Exception $mailException) {
                    Log::warning('Error enviando email desde success: ' . $mailException->getMessage());
                }
                
                // Eliminar los elementos del carrito
                $this->clearCart($order->user_id);
                
                // Limpiar la sesión
                Session::forget(['cart', 'order_id']);
            }
            
            return view('payment.success', compact('order'));
        } catch (ApiErrorException $e) {
            Log::error('Error de Stripe en página de éxito: ' . $e->getMessage());
            return redirect()->route('payment.failed')->with('error', 'Error al verificar el pago: ' . $e->getMessage());
        } catch (\Exception $e) {
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
                
                Log::info('Pedido marcado como fallido:', [
                    'order_id' => $order->id,
                    'had_discount' => $order->hasDiscount(),
                    'discount_code' => $order->discount_code
                ]);
            }
            
            return view('payment.failed', compact('order'));
        } catch (\Exception $e) {
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
                
                Log::info('Carrito vaciado correctamente para usuario #' . $userId);
                return true;
            }
            
            return false;
        } catch (\Exception $e) {
            Log::error('Error al vaciar el carrito: ' . $e->getMessage());
            return false;
        }
    }
}