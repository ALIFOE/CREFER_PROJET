<?php

namespace App\Services;

class EmailValidationService
{
    public function isAllowedDomain(string $email): bool
    {
        // Accepte tous les domaines d'email
        return true;
    }

    public function verifyEmailExists(string $email): bool
    {
        $domain = substr(strrchr($email, "@"), 1);
        $mxhosts = [];

        // Vérifie les enregistrements MX
        if (!getmxrr($domain, $mxhosts)) {
            return false;
        }

        return true;
    }
}
