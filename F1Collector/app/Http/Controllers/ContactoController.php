<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactoMail;

class ContactoController extends Controller
{
    public function enviar(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'politica' => 'required',
        ]);

        try {
            // Enviar el correo electrónico
            Mail::to(config('mail.contact.address', 'f1.collector12@gmail.com'))->send(new ContactoMail($validatedData));
            
            // Redirigir con mensaje de éxito
            return redirect()->route('contacto')->with('success', '¡Mensaje enviado con éxito! Nos pondremos en contacto contigo pronto.');
        } catch (\Exception $e) {
            // Log del error
            Log::error('Error al enviar email: ' . $e->getMessage());
            
            // Redirigir con mensaje de error
            return redirect()->route('contacto')->with('error', 'Ha ocurrido un error al enviar tu mensaje. Por favor, inténtalo de nuevo más tarde.');
        }
    }
}