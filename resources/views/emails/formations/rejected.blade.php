<x-mail::message>
# Inscription non retenue

Bonjour {{ $inscription->nom }},

Nous regrettons de vous informer que votre inscription à la formation **{{ $inscription->formation->titre }}** n'a pas été retenue.

Cette décision a été prise en tenant compte de différents critères, notamment le nombre limité de places disponibles et l'adéquation avec les prérequis de la formation.

Nous vous encourageons à consulter nos prochaines sessions de formation qui pourraient correspondre à vos attentes.

N'hésitez pas à nous contacter pour plus d'informations.

Cordialement,

L'équipe {{ config('app.name') }}
</x-mail::message>
