<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; // 👈 Añade esta línea
use Illuminate\Http\Request;
use Illuminate\View\View;



class ProductController extends Controller
{
    // Mostrar productos al público (catálogo)
    public function index()
    {
        $products = Product::paginate(10); // Catálogo público
        return view('catalogo', compact('products'));
    }

    // Mostrar todos los productos al admin
    public function adminIndex()
    {
        $products = Product::all(); // Para gestión, sin paginación
        return view('admin.products.index', compact('products'));
    }

    // Formulario de creación
    public function create()
    {
        $categories = Category::all(); // Ajusta si tu modelo se llama diferente
        return view('admin.products.create', compact('categories'));
    }

    // Guardar nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'team' => 'required|string|max:255',
            'year' => 'required|integer',
            'category_id' => 'required|exists:f1collector_categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'type' => 'required|string|max:255',
        ]);
    
        // Guardar imagen en storage/public/images y devolver ruta
        $imagePath = $request->file('image')->store('images', 'public');
    
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'team' => $request->team,
            'year' => $request->year,
            'category_id' => $request->category_id,
            'image' => 'storage/' . $imagePath, // Esto es lo que se guarda en la base de datos
            'description' => $request->description,
            'type' => $request->type,
        ]);
    
        return redirect()->route('admin.products.index')->with('success', 'Producto creado correctamente.');
    }
    
    
    // Formulario de edición
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // Guardar cambios
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $product->update($request->only(['name', 'price']));

        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado correctamente.');
    }

    // Eliminar producto
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado correctamente.');
    }
}
