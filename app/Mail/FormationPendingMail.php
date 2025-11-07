<?php

namespace App\Mail;

use App\Models\FormationInscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormationPendingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inscription;

    public function __construct(FormationInscription $inscription)
    {
        $this->inscription = $inscription;
    }

    public function build()
    {
        return $this->subject('Mise à jour de votre inscription à la formation')
                    ->markdown('emails.formations.pending');
    }
}
