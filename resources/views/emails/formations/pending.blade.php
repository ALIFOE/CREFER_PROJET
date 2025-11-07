<x-mail::message>
# Mise à jour de votre inscription

Bonjour {{ $inscription->nom }},

Votre inscription à la formation **{{ $inscription->formation->titre }}** est en cours d'examen.

## Détails de la formation
- Date de début : {{ $inscription->formation->date_debut->format('d/m/Y') }}
- Date de fin : {{ $inscription->formation->date_fin->format('d/m/Y') }}
- Durée : {{ $inscription->formation->date_debut->diffInDays($inscription->formation->date_fin) + 1 }} jours

Nous vous tiendrons informé de l'avancement de votre dossier dans les meilleurs délais.

Cordialement,

L'équipe {{ config('app.name') }}
</x-mail::message>
