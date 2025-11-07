<x-mail::message>
# Confirmation d'inscription à la formation

Bonjour {{ $inscription->nom }},

Nous avons bien reçu votre demande d'inscription à la formation suivante :

<x-mail::panel>
## {{ $inscription->formation->titre }}

**Date de début :** {{ $inscription->formation->date_debut->format('d/m/Y') }}
**Durée :** {{ $inscription->formation->duree }}
**Lieu :** {{ $inscription->formation->lieu }}
**Prix :** {{ number_format($inscription->formation->prix, 0, ',', ' ') }} FCFA
</x-mail::panel>

<x-mail::panel>
## Prérequis de la formation

@if($inscription->formation->prerequis)
@foreach(explode("\n", $inscription->formation->prerequis) as $prerequis)
✓ {{ $prerequis }}
@endforeach
@else
Aucun prérequis spécifique n'est nécessaire pour cette formation.
@endif
</x-mail::panel>

<x-mail::panel>
## Documents reçus
✓ Acte de naissance
✓ Carte nationale d'identité
✓ Diplôme
@if(count($inscription->autres_documents_paths ?? []) > 0)
✓ {{ count($inscription->autres_documents_paths) }} document(s) supplémentaire(s)
@endif
</x-mail::panel>

<x-mail::panel>
## Prochaines étapes

1. Examen de votre dossier (sous 48h)
2. Confirmation finale de l'inscription
3. Envoi des détails pratiques et du programme détaillé
</x-mail::panel>

<x-mail::panel>
## Contact responsable formation

👤 {{ $inscription->formation->responsable ?? 'Équipe pédagogique' }}
📞 +226 00 00 00 00
✉️ formation@crefer.com
</x-mail::panel>

<x-mail::button :url="config('app.url') . '/formations/suivi/' . $inscription->id" color="primary">
Suivre mon inscription
</x-mail::button>

Cordialement,<br>
L'équipe CREFER

<x-mail::subcopy>
Référence d'inscription : {{ $inscription->reference ?? $inscription->id }}
</x-mail::subcopy>
</x-mail::message>
