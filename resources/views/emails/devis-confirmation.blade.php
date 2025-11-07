<x-mail::message>
# Confirmation de votre demande de devis #{{ $devis->reference }}

Bonjour {{ $devis->nom }} {{ $devis->prenom }},

Nous avons bien reçu votre demande de devis et nous vous en remercions.

<x-mail::panel>
## Récapitulatif de votre demande

**Type de bâtiment :** {{ $devis->type_batiment }}
**Consommation annuelle :** {{ $devis->consommation_annuelle }} kWh
**Type de toiture :** {{ $devis->type_toiture }}
**Orientation :** {{ $devis->orientation }}
</x-mail::panel>

<x-mail::panel>
## Prochaines étapes

1. Notre équipe technique va analyser votre demande (délai : 24-48h)
2. Un expert vous contactera pour affiner le projet
3. Vous recevrez un devis détaillé par email
</x-mail::panel>

<x-mail::panel>
## Besoin d'aide ?

📞 Téléphone : +226 00 00 00 00
✉️ Email : contact@crefer.com
🕑 Horaires : Lun-Ven, 8h-18h
</x-mail::panel>

Cordialement,<br>
L'équipe CREFER

<x-mail::subcopy>
Référence de votre demande : {{ $devis->reference }}
</x-mail::subcopy>
</x-mail::message>
