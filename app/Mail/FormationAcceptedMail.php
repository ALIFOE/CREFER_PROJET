<?php

namespace App\Mail;

use App\Models\FormationInscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormationAcceptedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inscription;

    public function __construct(FormationInscription $inscription)
    {
        $this->inscription = $inscription;
    }

    public function build()
    {
        return $this->subject('Votre inscription à la formation a été acceptée')
                    ->markdown('emails.formations.accepted');
    }
}
