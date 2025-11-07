<x-mail::message>
# Confirmation de commande #{{ $order->id }}

Bonjour {{ $order->customer_name }},

Merci pour votre commande ! Nous vous confirmons la réception de votre commande n°{{ $order->id }}.

<x-mail::panel>
## Récapitulatif de la commande

@foreach($order->items as $item)
- {{ $item->quantity }}x {{ $item->product->name }} : {{ number_format($item->price * $item->quantity, 0, ',', ' ') }} FCFA
@endforeach

**Total :** {{ number_format($order->total_price, 0, ',', ' ') }} FCFA
</x-mail::panel>

<x-mail::panel>
## Détails de livraison

**Adresse :** {{ $order->customer_address }}
**Téléphone :** {{ $order->customer_phone }}
**Mode de paiement :** {{ $order->payment_method }}
**Délai de livraison estimé :** 3-5 jours ouvrés
</x-mail::panel>

<x-mail::panel>
## État de votre commande

1. ✓ Commande reçue
2. □ Paiement validé
3. □ Préparation en cours
4. □ En livraison
5. □ Livrée
</x-mail::panel>

<x-mail::button :url="config('app.url') . '/commandes/' . $order->id" color="primary">
Suivre ma commande
</x-mail::button>

<x-mail::panel>
## Besoin d'aide ?

📞 Service client : +226 00 00 00 00
✉️ Email : support@crefer.com
🕑 Horaires : Lun-Ven, 8h-18h
</x-mail::panel>

Cordialement,<br>
L'équipe CREFER

<x-mail::subcopy>
Commande #{{ $order->id }} | Date : {{ $order->created_at->format('d/m/Y H:i') }}
</x-mail::subcopy>
</x-mail::message>
        
        <h3 style="color: #333; margin-top: 20px;">Détails de votre commande :</h3>
        <ul style="list-style: none; padding: 0;">
            <li><strong>Produit :</strong> {{ $order->product->nom }}</li>
            <li><strong>Quantité :</strong> {{ $order->quantity }}</li>
            <li><strong>Prix unitaire :</strong> {{ number_format($order->product->prix, 0, ',', ' ') }} FCFA</li>
            <li><strong>Total :</strong> {{ number_format($order->total_price, 0, ',', ' ') }} FCFA</li>
            <li><strong>Méthode de paiement :</strong> {{ ucfirst($order->payment_method) }}</li>
        </ul>

        <h3 style="color: #333; margin-top: 20px;">Informations de livraison :</h3>
        <ul style="list-style: none; padding: 0;">
            <li><strong>Nom :</strong> {{ $order->customer_name }}</li>
            <li><strong>Email :</strong> {{ $order->customer_email }}</li>
            <li><strong>Téléphone :</strong> {{ $order->customer_phone }}</li>
            <li><strong>Adresse :</strong> {{ $order->customer_address }}</li>
        </ul>

        <ul>
            <h3 style="color: #333; margin-top: 20px;">Instructions de paiement Bancaire :</h3>
            <li>Veuillez effectuer le paiement de votre commande dans les 48 heures suivant la réception de cet e-mail.</li>
            <li>Les détails de paiement sont les suivants :</li>
            <ul style="list-style: none; padding: 0;">
                <li><strong>Nom du bénéficiaire :</strong> EGENT TOGO</li>
                <li><strong>Numéro de compte :</strong> 1234567890</li>
                <li><strong>Banque :</strong> Banque XYZ</li>
                <li><strong>BIC :</strong> XYZ123456</li>
                <li><strong>IBAN :</strong> FR76 1234 5678 9012 3456 7890 123</li>
            </ul>
            <ul>
                <h3 style="display: block; color: #333; margin-top: 20px;">Instructions de paiement par Mobile Money:</h3>
                <li>Les détails de paiement sont les suivants :</li>
                <ul style="list-style: none; padding: 0;">
                    <li><strong>Nom du bénéficiaire :</strong> EGENT TOGO</li>
                    <li><strong>Numéro de téléphone :</strong> +228 97 73 43 81</li>
                    <li><strong>Opérateur :</strong> Moov Africa</li>
                </ul>
                 <ul style="list-style: none; padding: 0;">
                    <li><strong>Nom du bénéficiaire :</strong> EGENT TOGO</li>
                    <li><strong>Numéro de téléphone :</strong> +228 90 37 95 56</li>
                    <li><strong>Opérateur :</strong> Mix By Yas</li>
                </ul>

            </ul>
            <ul>
                <li><strong>Montant :</strong> {{ number_format($order->total_price, 0, ',', ' ') }} FCFA</li>
                <li><strong>Référence de la commande :</strong> #{{ $order->id }}</li>
            </ul>
        </ul>

        <p style="margin-top: 20px;">Nous vous tiendrons informé de l'avancement de votre commande.</p>
        
        <p>Cordialement,<br>L'équipe EGENT TOGO</p>
    </div>
</body>
</html> 