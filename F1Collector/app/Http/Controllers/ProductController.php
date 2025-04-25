<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; // 👈 Añade esta línea
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Enums\Team;
use App\Enums\Scale;



class ProductController extends Controller
{
    // Mostrar productos al público (catálogo)
    public function index(Request $request)
    {
        $query = Product::query();
    
        // Filtro por escudería
        if ($request->has('teams')) {
            $query->whereIn('team', $request->teams);
        }
    
        // Filtro por escala
        if ($request->has('scales')) {
            $query->whereIn('type', $request->scales);
        }
    
        // Filtro por precio máximo
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
    
        // Ordenamiento
        switch ($request->input('ordenar')) {
            case 'Precio: Menor a Mayor':
                $query->orderBy('price', 'asc');
                break;
            case 'Precio: Mayor a Menor':
                $query->orderBy('price', 'desc');
                break;
            case 'Más Recientes':
                $query->orderBy('created_at', 'desc');
                break;
            case 'Más Populares':
                // Solo si tienes un campo de popularidad
                $query->orderBy('views', 'desc');
                break;
            default:
                // Relevancia o sin orden especial
                break;
        }
    
        $products = $query->paginate(9)->appends($request->all());
    
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
        $categories = Category::all();
        $teams = Team::values();
        $scales = Scale::values();
        return view('admin.products.create', compact('categories', 'teams', 'scales'));
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

        $categories = Category::all();
        $teams = Team::values();
        $scales = Scale::values();    
        return view('admin.products.edit', compact('product', 'categories', 'teams', 'scales'));
    }

    // Guardar cambios
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'team' => 'required|string|max:255',
            'year' => 'required|integer',
            'category_id' => 'required|exists:f1collector_categories,id',
            'description' => 'required|string',
            'type' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
    
        // Si suben una nueva imagen...
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $image = 'storage/' . $imagePath;
        } else {
            // ...si no, mantén la imagen antigua
            $image = $request->old_image;
        }
    
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'team' => $request->team,
            'year' => $request->year,
            'category_id' => $request->category_id,
            'image' => $image,
            'description' => $request->description,
            'type' => $request->type,
        ]);
    
        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado correctamente.');
    }
    

    // Eliminar producto
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado correctamente.');
    }
}
