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
    $address = null;
    if ($user->address_id) {
        $address = \App\Models\Address::find($user->address_id);
    }
    return view('admin.users.edit', compact('user', 'address'));
}

public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:f1collector_users,email,' . $user->id,
        'phone' => 'nullable|string|max:20|unique:f1collector_users,phone,' . $user->id,
        'user_type' => 'required|in:Admin,Customer',
        'password' => 'nullable|string|min:8',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'address' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:100',
        'postal_code' => 'nullable|string|max:10',
        'country' => 'nullable|string|max:100',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->user_type = $request->user_type;

    // Procesar avatar si se proporciona
    if ($request->hasFile('avatar')) {
        // Eliminar avatar anterior si existe
        if ($user->avatar && !str_contains($user->avatar, 'default') && file_exists(public_path($user->avatar))) {
            unlink(public_path($user->avatar));
        }
        
        // Guardar nuevo avatar
        $avatarName = 'avatar_' . $user->id . '_' . time() . '.' . $request->avatar->extension();
        $request->avatar->move(public_path('images/avatars'), $avatarName);
        $user->avatar = 'images/avatars/' . $avatarName;
    }

    // Procesar información de dirección
    if ($request->filled('address') || $request->filled('city') || 
        $request->filled('postal_code') || $request->filled('country')) {
        
        // Buscar si ya tiene una dirección asignada o crear una nueva
        $address = $user->address_id ? 
            \App\Models\Address::find($user->address_id) : 
            new \App\Models\Address;
        
        $address->address = $request->address;
        $address->city = $request->city;
        $address->postal_code = $request->postal_code;
        $address->country = $request->country;
        $address->save();
        
        // Asignar dirección al usuario si es nueva
        if (!$user->address_id) {
            $user->address_id = $address->id;
        }
    }

    // Actualizar contraseña si se proporciona
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('admin.users.index')
        ->with('success', 'Usuario actualizado correctamente');
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