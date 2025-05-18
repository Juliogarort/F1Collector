<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Métodos existentes para usuarios
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $address = null;
        if ($user->address_id) {
            $address = Address::find($user->address_id);
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
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->user_type = $request->user_type;

        // Procesar avatar si se proporciona
        if ($request->hasFile('avatar')) {
            // Crear directorio si no existe
            $avatarPath = public_path('images/avatars');
            if (!file_exists($avatarPath)) {
                mkdir($avatarPath, 0755, true);
            }
            
            // Eliminar avatar anterior si existe
            if ($user->avatar && !str_contains($user->avatar, 'default') && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }
            
            // Guardar nuevo avatar
            $avatarName = 'avatar_' . $user->id . '_' . time() . '.' . $request->avatar->extension();
            $request->avatar->move($avatarPath, $avatarName);
            $user->avatar = 'images/avatars/' . $avatarName;
        }

        // Procesar información de dirección
        if ($request->filled('street') || $request->filled('city') || 
            $request->filled('state') || $request->filled('postal_code') || 
            $request->filled('country')) {
            
            try {
                // Buscar si ya tiene una dirección asignada o crear una nueva
                $address = $user->address_id ? 
                    Address::find($user->address_id) : 
                    new Address();
                
                if ($address) {
                    $address->street = $request->street;
                    $address->city = $request->city;
                    $address->state = $request->state;
                    $address->postal_code = $request->postal_code;
                    $address->country = $request->country;
                    $address->save();
                    
                    // Asignar dirección al usuario si es nueva
                    if (!$user->address_id) {
                        $user->address_id = $address->id;
                    }
                } else {
                    Log::warning('No se pudo encontrar o crear la dirección para el usuario ID: ' . $user->id);
                }
            } catch (\Exception $e) {
                Log::error('Error al guardar la dirección: ' . $e->getMessage());
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
            if (optional(Auth::user())->id === $user->id) {
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

    // Nuevos métodos para gestión de pedidos
    /**
     * Mostrar listado de pedidos
     */
    public function ordersIndex()
    {
        $orders = Order::with('user')
                 ->orderBy('created_at', 'desc')
                 ->paginate(15);
                 
        return view('admin.orders.index', compact('orders'));
    }
    
    /**
     * Ver detalles de un pedido
     */
    public function orderShow(Order $order)
    {
        $order->load(['items.product', 'user']);
        return view('admin.orders.show', compact('order'));
    }
    
    /**
     * Actualizar estado de un pedido
     */
    public function orderUpdateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,paid,processing,shipped,delivered,cancelled',
        ]);
        
        try {
            $order->status = $validated['status'];
            $order->save();
            
            return redirect()->route('admin.orders.show', $order->id)
                             ->with('success', 'Estado del pedido actualizado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar estado del pedido: ' . $e->getMessage());
            
            return back()->with('error', 'Error al actualizar estado del pedido: ' . $e->getMessage());
        }
    }
}