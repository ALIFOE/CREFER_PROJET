<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    protected $signature = 'email:test';
    protected $description = 'Test l\'envoi d\'email';

    public function handle()
    {
        $this->info('Tentative d\'envoi d\'email de test...');

        try {
            $to = 'conceptart228@gmail.com';
            $subject = 'Test Email CREFER - ' . now();
            $content = 'Ceci est un email de test envoyé depuis l\'application CREFER. ' . now();

            Mail::raw($content, function($message) use ($to, $subject) {
                $message->to($to)
                        ->subject($subject)
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });

            $this->info('✓ Email envoyé avec succès à ' . $to);
            $this->info('✓ De : ' . config('mail.from.address'));
            $this->info('✓ Sujet : ' . $subject);
        } catch (\Exception $e) {
            $this->error('❌ Erreur lors de l\'envoi de l\'email :');
            $this->error($e->getMessage());
            
            // Afficher les paramètres de configuration
            $this->info('Configuration actuelle :');
            $this->info('MAIL_MAILER: ' . config('mail.default'));
            $this->info('MAIL_HOST: ' . config('mail.mailers.smtp.host'));
            $this->info('MAIL_PORT: ' . config('mail.mailers.smtp.port'));
            $this->info('MAIL_ENCRYPTION: ' . config('mail.mailers.smtp.encryption'));
            $this->info('MAIL_USERNAME: ' . config('mail.mailers.smtp.username'));
            $this->info('MAIL_FROM_ADDRESS: ' . config('mail.from.address'));
        }
    }
}
