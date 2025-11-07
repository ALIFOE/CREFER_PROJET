<?php

namespace App\Mail;

use App\Models\FormationInscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormationRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inscription;

    public function __construct(FormationInscription $inscription)
    {
        $this->inscription = $inscription;
    }

    public function build()
    {
        return $this->subject('Votre inscription à la formation n\'a pas été retenue')
                    ->markdown('emails.formations.rejected');
    }
}
