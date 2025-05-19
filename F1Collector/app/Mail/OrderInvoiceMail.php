<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class OrderInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Resumen de tu compra - Pedido #' . $this->order->id
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice',
            with: ['order' => $this->order]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
