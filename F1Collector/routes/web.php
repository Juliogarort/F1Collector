<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\CheckoutController;


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

Route::get('/wishlist', function () {
    return 'Aquí irá la lista de deseos 😎';
})->name('wishlist.index');


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