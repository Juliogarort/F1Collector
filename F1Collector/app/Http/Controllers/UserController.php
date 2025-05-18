<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User as EloquentUser;
use App\Models\Address;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{

    public function update(Request $request)
    {
        $user = EloquentUser::find(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20|unique:f1collector_users,phone,' . $user->id,
            'password' => 'nullable|string|min:8',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

// Procesar avatar si se proporciona (usando la misma lógica que AdminController)
        if ($request->hasFile('avatar')) {
            try {
                // Crear directorio si no existe
                $avatarPath = public_path('images/avatars');
                if (!file_exists($avatarPath)) {
                    mkdir($avatarPath, 0755, true);
                }
                
                // Eliminar avatar anterior si existe
                if ($user->avatar && !str_contains($user->avatar, 'default') && file_exists(public_path($user->avatar))) {
                    unlink(public_path($user->avatar));
                }
                
                // Guardar nuevo avatar usando el mismo formato que AdminController
                $avatarName = 'avatar_' . $user->id . '_' . time() . '.' . $request->avatar->extension();
                $request->avatar->move($avatarPath, $avatarName);
                $user->avatar = 'images/avatars/' . $avatarName;
            } catch (\Exception $e) {
                Log::error('Error al procesar el avatar: ' . $e->getMessage());
                // Continuar con el resto de la actualización
            }
        }

        // Guardar o actualizar dirección
        $addressData = $request->only(['street', 'city', 'state', 'postal_code', 'country']);

        if ($user->address) {
            $user->address->update($addressData);
        } elseif (array_filter($addressData)) {
            $address = Address::create($addressData);
            $user->address_id = $address->id;
        }

        $user->save();

        return response()->json(['message' => 'Perfil actualizado correctamente']);
    }


}
