<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);
    
        // ✅ Comprobamos que el usuario existe en la BBDD
        if (!User::where('email', $request->email)->exists()) {
            return back()->withErrors([
                'email' => 'Este usuario no está registrado.',
            ])->withInput();
        }
    
        // ✅ Intentamos iniciar sesión
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Inicio de sesión exitoso');
        }
    
        return back()->withErrors([
            'email' => 'Las credenciales no son válidas.',
        ])->withInput();
    }
   
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:f1collector_users,email'],
            'password' => ['required', 'min:8', 'confirmed'], // campo 'password_confirmation' requerido
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        Auth::login($user);
        return redirect('/')->with('success', 'Registro exitoso');
    }
    
}
