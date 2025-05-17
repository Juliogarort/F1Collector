<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:f1collector_users,email,' . $user->id,
            'phone' => 'nullable|string|max:20|unique:f1collector_users,phone,' . $user->id,
            'user_type' => 'required|in:Admin,Customer',
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->user_type = $request->user_type;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(User $user)
{
    try {
        // Evitar la eliminación del propio usuario administrador que está logueado
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'No puedes eliminar tu propio usuario administrador.');
        }

        // Primero eliminar relaciones que podrían bloquear la eliminación
        if ($user->shoppingCart) {
            // Eliminar los items del carrito primero
            $user->shoppingCart->items()->delete();
            $user->shoppingCart->delete();
        }

        if ($user->wishlist) {
            // Eliminar los items de la wishlist primero
            $user->wishlist->products()->detach();
            $user->wishlist->delete();
        }

        // Verificar si hay órdenes asociadas y manejarlas adecuadamente
        if (class_exists('\App\Models\Order') && method_exists('\App\Models\Order', 'where')) {
            $orders = \App\Models\Order::where('user_id', $user->id)->get();
            foreach ($orders as $order) {
                // Puedes decidir eliminar las órdenes o mantenerlas con usuario nulo
                // $order->orderItems()->delete(); // Eliminar items de la orden
                // $order->delete(); // Eliminar la orden
                
                // O simplemente desasociar el usuario
                $order->user_id = null;
                $order->save();
            }
        }

        // Finalmente eliminar el usuario
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente.');
            
    } catch (\Exception $e) {
        // Log del error para depuración
        Log::error('Error al eliminar usuario: ' . $e->getMessage());
        
        return redirect()->route('admin.users.index')
            ->with('error', 'No se pudo eliminar el usuario. Puede tener datos relacionados en el sistema que no se pueden eliminar automáticamente.');
    }
}
}