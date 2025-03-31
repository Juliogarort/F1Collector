<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Nueva ruta para el catálogo
Route::get('/catalogo', function () {
    return view('catalogo'); // Asegúrate de tener una vista llamada 'catalogo.blade.php'
})->name('catalogo');