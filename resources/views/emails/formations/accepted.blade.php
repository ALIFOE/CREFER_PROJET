<x-mail::message>
# Formation acceptée

Bonjour {{ $inscription->nom }},

Nous avons le plaisir de vous informer que votre inscription à la formation **{{ $inscription->formation->titre }}** a été acceptée.

## Détails de la formation
- Date de début : {{ $inscription->formation->date_debut->format('d/m/Y') }}
- Date de fin : {{ $inscription->formation->date_fin->format('d/m/Y') }}
- Durée : {{ $inscription->formation->date_debut->diffInDays($inscription->formation->date_fin) + 1 }} jours

Des informations complémentaires concernant l'organisation de la formation vous seront communiquées prochainement.

Cordialement,

L'équipe {{ config('app.name') }}
</x-mail::message>
