<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $statusLabels = [
        'pending' => 'En attente',
        'processing' => 'En cours de traitement',
        'completed' => 'Terminée',
        'cancelled' => 'Annulée'
    ];

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mise à jour de votre commande #' . $this->order->id,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.orders.status-updated',
            with: [
                'order' => $this->order,
                'statusLabel' => $this->statusLabels[$this->order->status] ?? $this->order->status
            ],
        );
    }
}
