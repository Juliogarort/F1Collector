<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Agregamos esta importación
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
public function generate(Order $order)
{
    // Verificar que el usuario actual es el propietario del pedido
    if (Auth::id() !== $order->user_id) {
        abort(403, 'No tienes permiso para acceder a esta factura');
    }
    
    // Cargar relaciones necesarias
    $order->load(['items.product', 'user']);
    
    // Convertir payment_date a objeto DateTime si es un string
    if ($order->payment_date && is_string($order->payment_date)) {
        $order->payment_date = new \DateTime($order->payment_date);
    }
    
    // Generar PDF
    $pdf = Pdf::loadView('invoices.template', compact('order'));
    
    // Establecer opciones del PDF
    $pdf->setPaper('a4');
    
    // Nombre del archivo de la factura
    $filename = 'factura-' . $order->id . '.pdf';
    
    // Descargar PDF
    return $pdf->download($filename);
}
}