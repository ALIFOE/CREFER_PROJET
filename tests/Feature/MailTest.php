<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

class MailTest extends TestCase
{
    /** @test */
    public function peut_envoyer_un_email()
    {
        try {
            // Désactive la file d'attente pour l'envoi immédiat
            config(['queue.default' => 'sync']);

            Mail::raw('Test email de CREFER', function (Message $message) {
                $message
                    ->to('conceptart228@gmail.com')
                    ->subject('Test Configuration Email CREFER')
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });

            $this->assertTrue(true, 'Email envoyé avec succès');
        } catch (\Exception $e) {
            $this->fail('Erreur lors de l\'envoi de l\'email: ' . $e->getMessage());
        }
    }
}