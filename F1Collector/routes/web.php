<?php
// coment prueba

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


Route::get('/', function () {
    return view('welcome');
});

// Nueva ruta para el catálogo
Route::get('/catalogo', function () {
    return view('catalogo'); // Asegúrate de tener una vista llamada 'catalogo.blade.php'
})->name('catalogo');


Route::get('/catalogo', [ProductController::class, 'index'])->name('catalogo');

// Ruta solo para usuarios logueados
Route::get('/profile', function () {
    return view('profile');
})->middleware('auth')->name('profile.index');

// Ruta solo para admins (lo veremos en el paso 2)
Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'is_admin'])->name('admin.dashboard');

// Ruta para el login y registro
/* Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login.custom');
    Route::post('/register', [AuthController::class, 'register'])->name('register.custom');
});*/

Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

// Ruta para pagina sobre nosotros 
Route::get('/nosotros', function () {
    return view('nosotros');
});



Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');

Route::post('/contacto/enviar', [ContactoController::class, 'enviar'])->name('contacto.enviar');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::match(['get', 'post'], '/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::get('/cart/remove/{itemId}', [CartController::class, 'removeItem'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');

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

Route::get('/usuario-logueado', function () {
    return response()->json(Auth::user());
})->middleware('auth');

// Rutas de checkout
Route::middleware(['auth'])->group(function () {

 // Esta ruta es un alias para checkout.index
Route::get('/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('checkout');

// Rutas de checkout (con autenticación)
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    
    // Rutas para la integración con Stripe
    Route::get('/payment/stripe/checkout', [App\Http\Controllers\PaymentController::class, 'stripeCheckout'])->name('payment.stripe.checkout');
    Route::get('/payment/success', [App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/failed', [App\Http\Controllers\PaymentController::class, 'failed'])->name('payment.failed');
    
    // Rutas para órdenes/pedidos
    Route::get('/orders', [App\Http\Controllers\CheckoutController::class, 'ordersIndex'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\CheckoutController::class, 'show'])->name('orders.show');
});
});

// Webhook de Stripe (no requiere autenticación)
Route::post('/payment/stripe/webhook', [App\Http\Controllers\PaymentController::class, 'stripeWebhook'])->name('payment.stripe.webhook');

Route::middleware('auth')->post('/profile/update', [UserController::class, 'update'])->name('profile.update');


Route::get('login/google', [App\Http\Controllers\AuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [App\Http\Controllers\AuthController::class, 'handleGoogleCallback']);