<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactoController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\ScaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ValoracionController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas principales del catálogo
Route::get('/catalogo', [ProductController::class, 'index'])->name('catalogo');

// Ruta solo para usuarios logueados
Route::get('/profile', function () {
    return view('profile');
})->middleware('auth')->name('profile.index');

// Ruta solo para admins
Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'is_admin'])->name('admin.dashboard');

// Rutas de wishlist
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

// Rutas estáticas
Route::get('/nosotros', function () {
    return view('nosotros');
})->name('nosotros');

Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');

Route::post('/contacto/enviar', [ContactoController::class, 'enviar'])->name('contacto.enviar');

// ✨ RUTAS DEL CARRITO Y DESCUENTOS
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::match(['get', 'post'], '/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::get('/cart/remove/{itemId}', [CartController::class, 'removeItem'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

// Rutas para descuentos en el carrito (requieren autenticación)
Route::middleware('auth')->group(function () {
    Route::post('/cart/apply-discount', [CartController::class, 'applyDiscount'])->name('cart.applyDiscount');
    Route::post('/cart/remove-discount', [CartController::class, 'removeDiscount'])->name('cart.removeDiscount');
});

// ✨ RUTAS DE CHECKOUT CORREGIDAS
Route::middleware(['auth'])->group(function () {
    // Esta ruta redirige al checkout usando CartController
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    
    // Rutas del proceso de checkout
    Route::get('/checkout/process', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    
    // Rutas para la integración con Stripe
    Route::get('/payment/stripe/checkout', [App\Http\Controllers\PaymentController::class, 'stripeCheckout'])->name('payment.stripe.checkout');
    Route::get('/payment/success', [App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/failed', [App\Http\Controllers\PaymentController::class, 'failed'])->name('payment.failed');
    
    // Rutas para órdenes/pedidos
    Route::get('/orders', [CheckoutController::class, 'ordersIndex'])->name('orders.index');
    Route::get('/orders/{order}', [CheckoutController::class, 'show'])->name('orders.show');
});

// Rutas de administración de productos
Route::middleware('auth')->prefix('admin/products')->name('admin.products.')->group(function () {
    Route::get('/', [ProductController::class, 'adminIndex'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
});

// Rutas para escuderías y escalas (admin)
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::resource('teams', TeamController::class)->names('admin.teams');
    Route::resource('scales', ScaleController::class)->names('admin.scales');
});

Route::get('/admin/menu', function() {
    return view('admin.menu');
})->middleware(['auth'])->name('admin.menu');

// Rutas para la administración de usuarios y pedidos
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/users', [AdminController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/orders', [AdminController::class, 'ordersIndex'])->name('admin.orders.index');
    Route::get('/orders/{order}', [AdminController::class, 'orderShow'])->name('admin.orders.show');
    Route::put('/orders/{order}/status', [AdminController::class, 'orderUpdateStatus'])->name('admin.orders.updateStatus');
});

// Rutas para la administración de usuarios (admin)
Route::get('/admin/users/create', [AdminController::class, 'create'])->name('admin.users.create');
Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.users.store');

// Ruta para el panel de analítica
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/analytics', [App\Http\Controllers\AnalyticsController::class, 'index'])->name('admin.analytics');
});

Route::get('/usuario-logueado', function () {
    return response()->json(Auth::user());
})->middleware('auth');

Route::get('/orders/{order}/invoice', [App\Http\Controllers\InvoiceController::class, 'generate'])
    ->name('orders.invoice')
    ->middleware('auth');

// Webhook de Stripe (no requiere autenticación)
Route::post('/payment/stripe/webhook', [App\Http\Controllers\PaymentController::class, 'stripeWebhook'])->name('payment.stripe.webhook');

Route::middleware('auth')->post('/profile/update', [UserController::class, 'update'])->name('profile.update');

// Rutas de autenticación con Google
Route::get('login/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [AuthController::class, 'handleGoogleCallback']);

// Rutas para valoraciones
Route::get('/valoraciones/mis-productos', [ValoracionController::class, 'productosParaValorar'])
    ->name('valoraciones.productos');
Route::get('/valoracion/{product}/crear', [ValoracionController::class, 'create'])
    ->name('valoraciones.create');
Route::post('/valoracion/{product}', [ValoracionController::class, 'store'])
    ->name('valoraciones.store');

Route::post('/session/clear-discount', function () {
    session()->forget('welcome_discount_code');
    return response()->json(['status' => 'ok']);
})->name('session.clear.discount');

