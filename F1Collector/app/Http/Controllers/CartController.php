<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartItem;
use App\Models\Product;
use App\Models\Discount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Mostrar el carrito en formato modal o página completa
     */
    public function index()
    {
        $cart = $this->getOrCreateCart();
        $items = $cart ? $cart->items()->with('product')->get() : collect([]);
        
        // Calcular subtotal (sin IVA)
        $subtotal = $items->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
        
        // Ya no calculamos IVA
        $total = $subtotal;
        
        // En lugar de intentar renderizar cart.index, redirigimos al catálogo 
        // con una señal para abrir el modal del carrito
        return redirect()->route('catalogo')->with('openCartModal', true);
    }
    
    /**
     * Añadir un producto al carrito
     */
    public function addToCart(Request $request)
    {
        // Validar
        $validated = $request->validate([
            'product_id' => 'required|exists:f1collector_products,id',
            'quantity' => 'required|integer|min:1|max:10' // Limitamos a 10 unidades máximo
        ]);
        
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión para añadir productos al carrito');
        }
        
        try {
            // Obtener el producto
            $product = Product::findOrFail($validated['product_id']);
            
            // Obtener o crear el carrito
            $cart = $this->getOrCreateCart();
            
            // Buscar si el producto ya está en el carrito
            $cartItem = ShoppingCartItem::where('shopping_cart_id', $cart->id)
                ->where('product_id', $validated['product_id'])
                ->first();
            
            // Si el producto ya está en el carrito, aumentar la cantidad (con límite)
            if ($cartItem) {
                $newQuantity = $cartItem->quantity + $validated['quantity'];
                
                // Verificar que no exceda el límite de 10 unidades
                if ($newQuantity > 10) {
                    return redirect()->back()
                        ->with('error', 'No puedes añadir más de 10 unidades de un producto');
                }
                
                $cartItem->quantity = $newQuantity;
                $cartItem->save();
            } else {
                // Si no, crear un nuevo item
                $cartItem = ShoppingCartItem::create([
                    'shopping_cart_id' => $cart->id,
                    'product_id' => $validated['product_id'],
                    'quantity' => $validated['quantity']
                ]);
            }
            
            // Limpiar descuentos aplicados porque el carrito cambió
            Session::forget(['applied_discount', 'checkout_discount_total', 'checkout_discount_code']);
            
            // Redireccionar con mensaje de éxito
            $productName = $product->name; // Para mostrar el nombre en el mensaje
            return redirect()->back()
                ->with('success', "Producto '{$productName}' añadido al carrito");
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al añadir el producto: ' . $e->getMessage());
        }
    }
    
    /**
     * Aplicar código de descuento
     */
    public function applyDiscount(Request $request)
    {
        $request->validate([
            'discount_code' => 'required|string|max:50'
        ]);

        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Debes iniciar sesión para aplicar descuentos');
        }

        try {
            $cart = $this->getOrCreateCart();
            $items = $cart->items()->with(['product', 'product.category'])->get();

            if ($items->isEmpty()) {
                return redirect()->back()->with('error', 'Tu carrito está vacío');
            }

            // Buscar el código de descuento
            $discount = Discount::where('code', $request->discount_code)->first();

            if (!$discount || !$discount->isValid()) {
                return redirect()->back()->with('error', 'Código de descuento inválido o expirado');
            }

            // Calcular subtotal
            $subtotal = $items->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });

            // Calcular el descuento según el tipo
            $discountAmount = $this->calculateDiscountAmount($discount, $items, $subtotal);

            if ($discountAmount <= 0) {
                return redirect()->back()->with('error', 'Este descuento no es aplicable a los productos en tu carrito');
            }

            // Guardar el descuento en la sesión
            Session::put('applied_discount', [
                'code' => $discount->code,
                'discount_id' => $discount->id,
                'amount' => $discountAmount,
                'type' => $discount->type
            ]);

            return redirect()->back()->with('success', "¡Descuento aplicado! Ahorras €" . number_format($discountAmount, 2));

        } catch (\Exception $e) {
            Log::error('Error aplicando descuento: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al aplicar el descuento');
        }
    }

    /**
     * Calcular el monto del descuento
     */
    private function calculateDiscountAmount($discount, $items, $subtotal)
    {
        $eligibleTotal = 0;

        switch ($discount->type) {
            case 'simple':
                // Descuento simple: se aplica al total del carrito
                $eligibleTotal = $subtotal;
                break;

            case 'category':
                // Descuento por categoría: solo productos de esa categoría
                $eligibleTotal = $items->where('product.category_id', $discount->category_id)
                    ->sum(function ($item) {
                        return $item->quantity * $item->product->price;
                    });
                break;

            case 'product':
                // Descuento por producto específico
                $eligibleTotal = $items->where('product_id', $discount->product_id)
                    ->sum(function ($item) {
                        return $item->quantity * $item->product->price;
                    });
                break;
        }

        // Calcular el descuento
        if ($discount->discount_percentage) {
            return $eligibleTotal * ($discount->discount_percentage / 100);
        }

        if ($discount->discount_amount) {
            return min($discount->discount_amount, $eligibleTotal);
        }

        return 0;
    }

    /**
     * Remover código de descuento
     */
    public function removeDiscount()
    {
        Session::forget(['applied_discount', 'checkout_discount_total', 'checkout_discount_code']);
        return redirect()->back()->with('success', 'Descuento removido');
    }
    
    /**
     * Actualizar la cantidad de un producto en el carrito
     */
    public function updateQuantity(Request $request)
    {
        // Validar
        $validated = $request->validate([
            'item_id' => 'required|exists:f1collector_shopping_cart_items,id',
            'quantity' => 'required|integer|min:1|max:10' // Limitamos a 10 unidades máximo
        ]);
        
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión para actualizar el carrito');
        }
        
        try {
            // Buscar el item
            $cartItem = ShoppingCartItem::with('product')
                ->whereHas('shoppingCart', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->findOrFail($validated['item_id']);
            
            // Actualizar cantidad
            $cartItem->quantity = $validated['quantity'];
            $cartItem->save();
            
            // Limpiar descuentos aplicados porque el carrito cambió
            Session::forget(['applied_discount', 'checkout_discount_total', 'checkout_discount_code']);
            
            $productName = $cartItem->product->name; // Para mostrar el nombre en el mensaje
            return redirect()->back()
                ->with('success', "Cantidad de '{$productName}' actualizada correctamente");
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar la cantidad: ' . $e->getMessage());
        }
    }
    
    /**
     * Eliminar un producto del carrito
     */
    public function removeItem(Request $request, $itemId)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión para eliminar productos del carrito');
        }
        
        try {
            // Primero obtenemos el item para poder mostrar su nombre en el mensaje de éxito
            $cartItem = ShoppingCartItem::with('product')
                ->whereHas('shoppingCart', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->where('id', $itemId)
                ->first();
                
            if (!$cartItem) {
                return redirect()->back()
                    ->with('error', 'No se encontró el producto en el carrito');
            }
            
            $productName = $cartItem->product->name;
            
            // Ahora eliminamos el item
            $cartItem->delete();
            
            // Limpiar descuentos aplicados porque el carrito cambió
            Session::forget(['applied_discount', 'checkout_discount_total', 'checkout_discount_code']);
            
            return redirect()->back()
                ->with('success', "Producto '{$productName}' eliminado del carrito");
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }
    
    /**
     * Vaciar todo el carrito
     */
    public function clearCart()
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión para vaciar el carrito');
        }
        
        try {
            // Obtener el carrito
            $cart = $this->getOrCreateCart();
            
            // Eliminar todos los items
            ShoppingCartItem::where('shopping_cart_id', $cart->id)->delete();
            
            // Limpiar descuento aplicado
            Session::forget(['applied_discount', 'checkout_discount_total', 'checkout_discount_code']);
            
            return redirect()->back()
                ->with('success', 'Carrito vaciado correctamente');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al vaciar el carrito: ' . $e->getMessage());
        }
    }
    
    /**
     * Procesar el checkout
     */
    public function checkout()
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Debes iniciar sesión para finalizar la compra');
    }

    try {
        $cart = $this->getOrCreateCart();
        $items = $cart->items()->with('product')->get();

        if ($items->isEmpty()) {
            return redirect()->route('catalogo')->with('error', 'El carrito está vacío. Añade productos antes de finalizar la compra.');
        }

        $subtotal = $items->sum(fn($item) => $item->quantity * $item->product->price);
        $total = $subtotal;

        // Aplicar descuento si existe
        $discountAmount = 0;
        $appliedDiscount = Session::get('applied_discount');
        
        if ($appliedDiscount) {
            $discountAmount = $appliedDiscount['amount'];
            $total = max(0, $subtotal - $discountAmount); // No permitir totales negativos
        }

        // Obtener la dirección si existe
        $address = Auth::user()->address;

        // ✨ NUEVO: Obtener cupones disponibles
        $availableCoupons = collect();
        $bestCoupon = null;
        
        if (!$appliedDiscount) {
            $availableCoupons = \App\Models\Discount::getAvailableCoupons(3);
            $bestCoupon = \App\Models\Discount::getBestAvailableCoupon();
        }

        return view('checkout', [
            'items' => $items,
            'subtotal' => $subtotal,
            'shipping' => 0,
            'total' => $total,
            'address' => $address,
            'discountAmount' => $discountAmount,
            'appliedDiscount' => $appliedDiscount,
            'availableCoupons' => $availableCoupons,  // ← Nuevo
            'bestCoupon' => $bestCoupon,              // ← Nuevo
        ]);
    } catch (\Exception $e) {
        return redirect()->route('catalogo')->with('error', 'Error al procesar el checkout: ' . $e->getMessage());
    }
}
    
    /**
     * Método privado para obtener o crear el carrito del usuario actual
     */
    private function getOrCreateCart()
    {
        if (!Auth::check()) {
            return null;
        }
        
        try {
            // Buscar un carrito para el usuario
            $cart = ShoppingCart::where('user_id', Auth::id())
                ->first();
            
            // Si no existe, crear uno nuevo
            if (!$cart) {
                $cart = ShoppingCart::create([
                    'user_id' => Auth::id()
                ]);
            }
            
            return $cart;
            
        } catch (\Exception $e) {
            Log::error('Error al obtener/crear carrito: ' . $e->getMessage());
            return null;
        }
    }
}