<?php

namespace App\Http\Controllers;

use App\Models\Product; // Importa el modelo de Producto

class ProductController extends Controller
{
    public function index()
    {
        // Obtener todos los productos desde la base de datos
        $products = Product::paginate(10); // Paginación de 10 productos por página

        // Pasar los productos a la vista 'catalogo'
        return view('catalogo', compact('products'));
    }
}
