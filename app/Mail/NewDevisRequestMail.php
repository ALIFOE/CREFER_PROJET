<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewDevisRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $devis;

    public function __construct($devis)
    {
        $this->devis = $devis;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle demande de devis',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.admin.new-devis-request',
            with: [
                'devis' => $this->devis
            ],
        );
    }
}
