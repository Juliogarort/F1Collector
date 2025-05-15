<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\ShoppingCart;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Redireccionar al usuario a Google para autenticarse
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Recibir la respuesta de Google después de la autenticación
public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->user();
        
        // Verificar si es un usuario nuevo antes de crearlo/actualizarlo
        $isNewUser = !User::where('email', $googleUser->email)->exists();

        // Buscar usuario existente
        $existingUser = User::where('email', $googleUser->email)->first();
        
        if ($existingUser) {
            Log::info('Usuario existente encontrado', ['user_id' => $existingUser->id]);
            
            // Actualizar google_id si es necesario
            if (empty($existingUser->google_id)) {
                $existingUser->google_id = $googleUser->id;
                $existingUser->save();
                Log::info('Google ID actualizado para usuario existente');
            }
            
            $user = $existingUser;
        } else {
            Log::info('Creando nuevo usuario con Google');
            
            // Crear nuevo usuario
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt(Str::random(16)),
                'google_id' => $googleUser->id,
                'email_verified_at' => now(),
                'user_type' => 'Customer',
            ]);
            
            Log::info('Nuevo usuario creado', ['user_id' => $user->id]);
            
            // Crear recursos para el usuario
            $this->createUserResources($user);
        }
        
        // Login con regeneración de sesión
        Auth::login($user);
        session()->regenerate();
        
        if (Auth::check()) {
            Log::info('Login exitoso con Google', ['user_id' => Auth::id()]);
            
            // Si es un usuario nuevo, redirigir con bandera para mostrar el modal
            if ($isNewUser) {
                Log::info('Abriendo modal de perfil para establecer contraseña para nuevo usuario');
                return redirect('/')->with([
                    'success' => '¡Inicio de sesión con Google exitoso! Para mejorar la seguridad de tu cuenta, establece una contraseña.',
                    'openProfileModal' => true,
                    'focusPasswordField' => true
                ]);
            }
            
            return redirect('/')->with('success', '¡Inicio de sesión con Google exitoso!');
        } else {
            Log::error('Fallo en login después de autenticación con Google');
            return redirect()->route('login')->with('error', 'Error al iniciar sesión. Por favor, intenta de nuevo.');
        }

    } catch (\Exception $e) {
        Log::error('Error en autenticación con Google', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()->route('login')->with('error', 'Error al iniciar sesión con Google: ' . $e->getMessage());
    }
}
    
    /**
     * Crear recursos iniciales para el usuario
     */
    private function createUserResources(User $user)
    {
        try {
            // Crear carrito de compras
            $cart = new ShoppingCart();
            $cart->user_id = $user->id;
            $cart->save();
            Log::info('Carrito creado para nuevo usuario', ['cart_id' => $cart->id]);
            
            // Crear wishlist
            $wishlist = new Wishlist();
            $wishlist->user_id = $user->id;
            $wishlist->save();
            Log::info('Wishlist creada para nuevo usuario', ['wishlist_id' => $wishlist->id]);
            
        } catch (\Exception $e) {
            Log::error('Error al crear recursos para usuario', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}