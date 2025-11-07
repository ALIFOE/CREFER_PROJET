<x-mail::message>
# Nouvelle demande de devis

Une nouvelle demande de devis a été soumise.

<x-mail::panel>
## Informations du client

**Nom :** {{ $devis->nom }} {{ $devis->prenom }}
**Email :** {{ $devis->email }}
**Téléphone :** {{ $devis->telephone }}
**Adresse :** {{ $devis->adresse }}
</x-mail::panel>

<x-mail::panel>
## Détails du projet

**Type de bâtiment :** {{ $devis->type_batiment }}
**Consommation annuelle :** {{ $devis->consommation_annuelle }} kWh
**Type de toiture :** {{ $devis->type_toiture }}
**Orientation :** {{ $devis->orientation }}

@if($devis->objectifs)
**Objectifs :**
@foreach($devis->objectifs as $objectif)
- {{ $objectif }}
@endforeach
@endif
</x-mail::panel>

@if($devis->message)
<x-mail::panel>
## Message du client

{{ $devis->message }}
</x-mail::panel>
@endif

<x-mail::panel>
## Analyse technique préliminaire

@foreach(json_decode($devis->analyse_technique, true) as $key => $value)
**{{ ucfirst(str_replace('_', ' ', $key)) }} :** {{ is_array($value) ? implode(', ', $value) : $value }}
@endforeach
</x-mail::panel>

<x-mail::button :url="config('app.url') . '/admin/devis/' . $devis->id">
Voir les détails du devis
</x-mail::button>

Cordialement,<br>
{{ config('app.name') }}
</x-mail::message>