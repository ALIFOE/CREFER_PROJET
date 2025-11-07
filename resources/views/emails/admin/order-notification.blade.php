<x-mail::message>
# Nouvelle commande #{{ $order->id }}

Une nouvelle commande a été passée.

<x-mail::panel>
## Informations du client

**Nom :** {{ $order->customer_name }}
**Email :** {{ $order->customer_email }}
**Téléphone :** {{ $order->customer_phone }}
**Adresse de livraison :** {{ $order->customer_address }}
</x-mail::panel>

<x-mail::panel>
## Détails de la commande

@foreach($order->items as $item)
- {{ $item->quantity }}x {{ $item->product->name }} ({{ number_format($item->price * $item->quantity, 0, ',', ' ') }} FCFA)
@endforeach

**Total :** {{ number_format($order->total_price, 0, ',', ' ') }} FCFA
**Mode de paiement :** {{ $order->payment_method }}
</x-mail::panel>

<x-mail::button :url="config('app.url') . '/admin/orders/' . $order->id" color="primary">
Gérer la commande
</x-mail::button>

@if($order->notes)
<x-mail::panel>
## Notes du client

{{ $order->notes }}
</x-mail::panel>
@endif

Cordialement,<br>
{{ config('app.name') }}

<x-mail::subcopy>
Commande #{{ $order->id }} | Date : {{ $order->created_at->format('d/m/Y H:i') }}
</x-mail::subcopy>
</x-mail::message>