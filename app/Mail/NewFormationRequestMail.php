<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewFormationRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inscription;

    public function __construct($inscription)
    {
        $this->inscription = $inscription;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle inscription à une formation',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.admin.new-formation-request',
            with: [
                'inscription' => $this->inscription
            ],
        );
    }
}
