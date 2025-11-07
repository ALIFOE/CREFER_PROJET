<x-mail::message>
# Confirmation de votre demande de service #{{ $serviceRequest->id }}

Bonjour {{ $serviceRequest->nom }},

Nous avons bien reçu votre demande de service et nous vous en remercions.

<x-mail::panel>
## Récapitulatif de votre demande

**Service demandé :** {{ $serviceRequest->service->nom }}
**Description :** {{ $serviceRequest->description }}
**Date de la demande :** {{ $serviceRequest->created_at->format('d/m/Y') }}

@if($serviceRequest->champs_specifiques && count($serviceRequest->champs_specifiques) > 0)
### Informations complémentaires :
@foreach($serviceRequest->champs_specifiques as $champ => $valeur)
**{{ $champ }} :** {{ $valeur }}
@endforeach
@endif
</x-mail::panel>

<x-mail::panel>
## Prochaines étapes

1. Analyse de votre demande (sous 24h)
2. Contact par un technicien spécialisé
3. Planification de l'intervention
4. Réalisation du service
</x-mail::panel>

<x-mail::panel>
## Délais estimés

- Analyse de la demande : 24h
- Premier contact : 48h
- Intervention : selon disponibilité et urgence
</x-mail::panel>

<x-mail::button :url="config('app.url') . '/services/suivi/' . $serviceRequest->id" color="primary">
Suivre ma demande
</x-mail::button>

<x-mail::panel>
## Contact service technique

📞 Support technique : +226 00 00 00 00
✉️ Email : technique@crefer.com
🕑 Horaires : Lun-Ven, 8h-18h
</x-mail::panel>

Cordialement,<br>
L'équipe CREFER

<x-mail::subcopy>
Référence de service : {{ $serviceRequest->reference ?? $serviceRequest->id }} | Date : {{ $serviceRequest->created_at->format('d/m/Y H:i') }}
</x-mail::subcopy>
</x-mail::message>
