<x-mail::message>
# Nouvelle demande de service

Une nouvelle demande de service a été soumise.

<x-mail::panel>
## Informations du client

**Nom :** {{ $serviceRequest->nom }}
**Email :** {{ $serviceRequest->email }}
**Téléphone :** {{ $serviceRequest->telephone }}
**Adresse :** {{ $serviceRequest->adresse }}
</x-mail::panel>

<x-mail::panel>
## Détails de la demande

**Service demandé :** {{ $serviceRequest->service->nom }}
**Date souhaitée :** {{ $serviceRequest->date_souhaitee ? $serviceRequest->date_souhaitee->format('d/m/Y') : 'Non spécifiée' }}
**Description :** {{ $serviceRequest->description }}

@if($serviceRequest->champs_specifiques && count($serviceRequest->champs_specifiques) > 0)
### Informations complémentaires :
@foreach($serviceRequest->champs_specifiques as $champ => $valeur)
**{{ ucfirst($champ) }} :** {{ $valeur }}
@endforeach
@endif
</x-mail::panel>

@if($serviceRequest->fichiers && count($serviceRequest->fichiers) > 0)
<x-mail::panel>
## Documents joints

@foreach($serviceRequest->fichiers as $fichier)
- {{ $fichier->nom_original }}
@endforeach
</x-mail::panel>
@endif

<x-mail::button :url="config('app.url') . '/admin/services/' . $serviceRequest->id" color="primary">
Traiter la demande
</x-mail::button>

Cordialement,<br>
{{ config('app.name') }}

<x-mail::subcopy>
Demande #{{ $serviceRequest->id }} | Date : {{ $serviceRequest->created_at->format('d/m/Y H:i') }}
</x-mail::subcopy>
</x-mail::message>