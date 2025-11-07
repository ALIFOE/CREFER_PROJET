@component('mail::message')
# Mise à jour de votre commande #{{ $order->id }}

Cher(e) {{ $order->customer_name }},

Le statut de votre commande a été mis à jour.

**Nouveau statut :** {{ $statusLabel }}

## Détails de la commande
- **Produit :** {{ $order->product->nom }}
- **Quantité :** {{ $order->quantity }}
- **Prix total :** {{ number_format($order->total_price, 0, ',', ' ') }} FCFA

@if($order->status === 'completed')
Votre commande a été complétée avec succès. Nous vous remercions de votre confiance !
@elseif($order->status === 'processing')
Votre commande est en cours de traitement. Nous faisons de notre mieux pour la traiter rapidement.
@elseif($order->status === 'cancelled')
Votre commande a été annulée. Si vous avez des questions, n'hésitez pas à nous contacter.
@else
Nous vous tiendrons informé des prochaines mises à jour de votre commande.
@endif

Si vous avez des questions, n'hésitez pas à nous contacter.

Cordialement,<br>
L'équipe {{ config('app.name') }}
@endcomponent
