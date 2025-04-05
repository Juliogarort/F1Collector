<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

// Nueva ruta para el catálogo
Route::get('/catalogo', function () {
    return view('catalogo'); // Asegúrate de tener una vista llamada 'catalogo.blade.php'
})->name('catalogo');


Route::get('/catalogo', [ProductController::class, 'index'])->name('catalogo');
