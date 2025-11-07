<?php

namespace App\Mail;

use App\Models\Devis;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminDevisNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(protected Devis $devis)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle demande de devis - ' . $this->devis->nom . ' ' . $this->devis->prenom,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.devis-notification',
            with: [
                'devis' => $this->devis
            ]
        );
    }
}