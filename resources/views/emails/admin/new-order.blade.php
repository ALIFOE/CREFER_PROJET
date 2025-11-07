@component('mail::message')
# Nouvelle commande reçue

Une nouvelle commande a été passée sur le site.

## Détails de la commande
- **Numéro :** #{{ $order->id }}
- **Client :** {{ $order->customer_name }}
- **Email :** {{ $order->customer_email }}
- **Produit :** {{ $order->product->nom }}
- **Quantité :** {{ $order->quantity }}
- **Total :** {{ number_format($order->total_price, 0, ',', ' ') }} FCFA

@component('mail::button', ['url' => route('admin.orders.show', $order)])
Voir la commande
@endcomponent

Cordialement,<br>
{{ config('app.name') }}
@endcomponent
