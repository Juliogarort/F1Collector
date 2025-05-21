<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Team;
use App\Models\Scale;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Mostrar productos al público (catálogo)
    public function index(Request $request)
    {
        $query = Product::query();

        // Filtro por escudería - Ahora usando la relación correcta
        if ($request->has('teams') && !empty($request->teams)) {
            $query->whereIn('team_id', $request->teams);
        }

        // Filtro por escala - Ahora usando la relación correcta
        if ($request->has('scales') && !empty($request->scales)) {
            $query->whereIn('scale_id', $request->scales);
        }

        // Filtro por precio mínimo
        if ($request->has('min_price') && is_numeric($request->min_price)) {
            $query->where('price', '>=', $request->min_price);
        }

        // Filtro por precio máximo
        if ($request->has('max_price') && is_numeric($request->max_price)) {
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
                // Por defecto usar fecha de creación para ordenar por popularidad
                $query->orderBy('created_at', 'desc');
                break;
            default:
                // Relevancia o sin orden especial
                $query->orderBy('created_at', 'desc'); // Por defecto ordenar por más recientes
                break;
        }

        // Cargar relaciones para evitar N+1 queries, incluyendo valoraciones
        $products = $query->with(['team', 'scale', 'category', 'valoraciones'])
            ->withCount(['valoraciones' => function ($query) {
                $query->where('aprobada', true);
            }])
            ->withAvg(['valoraciones' => function ($query) {
                $query->where('aprobada', true);
            }], 'puntuacion')
            ->paginate(9)
            ->appends($request->all());

        // Obtener valores para filtros
        $teams = Team::orderBy('name')->get();
        $scales = Scale::orderBy('value')->get();

        return view('catalogo', compact('products', 'teams', 'scales'));
    }

    // Mostrar todos los productos al admin
    public function adminIndex()
    {
        // Cargar relaciones para evitar N+1 queries
        $products = Product::with(['team', 'scale', 'category'])->get();
        return view('admin.products.index', compact('products'));
    }

    // Formulario de creación
    public function create()
    {
        $categories = Category::all();
        $teams = Team::all();
        $scales = Scale::all();
        return view('admin.products.create', compact('categories', 'teams', 'scales'));
    }

    // Formulario de edición
    public function edit(Product $product)
    {
        $categories = Category::all();
        $teams = Team::all();
        $scales = Scale::all();

        return view('admin.products.edit', compact('product', 'categories', 'teams', 'scales'));
    }

    // Guardar nuevo producto
    public function store(Request $request)
    {
        Log::info('Intento de creación de producto');
        Log::info('Datos recibidos:', $request->all());

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'team_id' => 'required|exists:f1collector_teams,id',
                'year' => 'required|integer',
                'category_id' => 'required|exists:f1collector_categories,id',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'description' => 'required|string',
                'scale_id' => 'required|exists:f1collector_scales,id',
            ]);

            Log::info('Validación exitosa:', $validated);

            // Guardar imagen en public/images (en lugar de storage/public/images)
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            Log::info('Imagen guardada en: images/' . $imageName);

            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'team_id' => $request->team_id,
                'year' => $request->year,
                'category_id' => $request->category_id,
                'image' => 'images/' . $imageName,  // Sin la barra inicial
                'description' => $request->description,
                'scale_id' => $request->scale_id,
            ]);

            Log::info('Producto creado con ID: ' . $product->id);

            return redirect()->route('admin.products.index')->with('success', 'Producto creado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear producto: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->with('error', 'Error al crear producto: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Guardar cambios
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'team_id' => 'required|exists:f1collector_teams,id',
            'year' => 'required|integer',
            'category_id' => 'required|exists:f1collector_categories,id',
            'description' => 'required|string',
            'scale_id' => 'required|exists:f1collector_scales,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Gestionar imagen
        if ($request->hasFile('image')) {
            // Eliminar imagen antigua si existe
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            // Guardar nueva imagen
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $image = 'images/' . $imageName;
        } else {
            $image = $request->old_image;
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'team_id' => $request->team_id,
            'year' => $request->year,
            'category_id' => $request->category_id,
            'image' => $image,
            'description' => $request->description,
            'scale_id' => $request->scale_id,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado correctamente.');
    }

    // Eliminar producto
    public function destroy(Product $product)
    {
        // Eliminar la imagen asociada al producto
        if ($product->image && file_exists(public_path($product->image))) {
            // Eliminar la parte /storage/ de la ruta para obtener la ruta relativa
            $imagePath = str_replace('/storage/', '', $product->image);
            Storage::disk('public')->delete($imagePath);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado correctamente.');
    }
}
