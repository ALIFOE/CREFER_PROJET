<?php

namespace App\Services;

use App\Models\AdminNotificationEmail;
use Illuminate\Support\Facades\Mail;

class AdminNotificationService
{
    public function notifyAdmins($mailable, $type)
    {
        // Récupérer tous les emails admin qui ont activé ce type de notification
        $adminEmails = AdminNotificationEmail::where($type, true)
            ->pluck('email')
            ->toArray();

        // Ajouter l'email admin par défaut depuis .env
        $defaultAdminEmail = config('mail.admin_email');
        if ($defaultAdminEmail && !in_array($defaultAdminEmail, $adminEmails)) {
            $adminEmails[] = $defaultAdminEmail;
        }

        // Envoyer l'email à tous les admins
        foreach ($adminEmails as $email) {
            Mail::to($email)->send($mailable);
        }
    }
}
