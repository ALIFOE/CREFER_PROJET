@component('mail::message')
# Nouvelle inscription à une formation

Une nouvelle inscription à une formation a été reçue.

## Détails de l'inscription
- **Formation :** {{ $inscription->formation->titre }}
- **Participant :** {{ $inscription->nom }} {{ $inscription->prenom }}
- **Email :** {{ $inscription->email }}
- **Téléphone :** {{ $inscription->telephone }}

@component('mail::button', ['url' => route('admin.formations.inscriptions.show', $inscription)])
Voir l'inscription
@endcomponent

Cordialement,<br>
{{ config('app.name') }}
@endcomponent
