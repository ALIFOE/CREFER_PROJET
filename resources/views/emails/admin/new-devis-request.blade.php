@component('mail::message')
# Nouvelle demande de devis

Une nouvelle demande de devis a été reçue.

## Détails du client
- **Nom :** {{ $devis->nom }} {{ $devis->prenom }}
- **Email :** {{ $devis->email }}
- **Téléphone :** {{ $devis->telephone }}
- **Adresse :** {{ $devis->adresse }}

## Détails de la demande
- **Type de bâtiment :** {{ $devis->type_batiment }}
- **Facture mensuelle :** {{ number_format($devis->facture_mensuelle, 0, ',', ' ') }} FCFA
- **Consommation annuelle :** {{ number_format($devis->consommation_annuelle, 0, ',', ' ') }} kWh
- **Type de toiture :** {{ $devis->type_toiture }}
- **Orientation :** {{ $devis->orientation }}

### Message du client
{{ $devis->message }}

@component('mail::button', ['url' => route('admin.devis.show', $devis)])
Voir le devis
@endcomponent

Cordialement,<br>
{{ config('app.name') }}
@endcomponent
