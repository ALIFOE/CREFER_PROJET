<?php

namespace App\Mail;

use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminServiceRequestNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(protected ServiceRequest $serviceRequest)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle demande de service - ' . $this->serviceRequest->nom,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.service-request-notification',
            with: [
                'serviceRequest' => $this->serviceRequest
            ]
        );
    }
}