<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Mail\AdminOrderNotificationMail;
use App\Mail\OrderConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Events\ClientActivity;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'payment_method' => 'required|in:carte,virement'
        ]);

        $product = Product::findOrFail($validatedData['product_id']);
        $total_price = $product->price * $validatedData['quantity'];

        $order = Order::create([
            'product_id' => $validatedData['product_id'],
            'user_id' => auth()->id(),
            'quantity' => $validatedData['quantity'],
            'total_price' => $total_price,
            'status' => 'pending',
            'payment_method' => $validatedData['payment_method'],
            'customer_name' => $validatedData['customer_name'],
            'customer_email' => $validatedData['customer_email'],
            'customer_phone' => $validatedData['customer_phone'],
            'customer_address' => $validatedData['customer_address']
        ]);        try {
            // Envoyer l'e-mail de confirmation au client
            Mail::to($validatedData['customer_email'])->send(new OrderConfirmationMail($order));
            
            // Envoyer une notification à tous les administrateurs
            Mail::to(User::getAdminEmails())->send(new AdminOrderNotificationMail($order));
            
            \Log::info('Emails de commande envoyés avec succès', [
                'order_id' => $order->id,
                'client_email' => $validatedData['customer_email'],
                'admin_emails' => User::getAdminEmails()
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'envoi des emails de commande', [
                'error' => $e->getMessage(),
                'order_id' => $order->id
            ]);
        }

        // Déclencher l'événement pour notifier les administrateurs
        event(new ClientActivity('order_placed', [
            'name' => $validatedData['customer_name'],
            'email' => $validatedData['customer_email'],
            'id' => $order->id,
            'amount' => $total_price
        ]));

        // Envoyer l'e-mail de confirmation au client
        Mail::to($order->customer_email)->send(new OrderConfirmationMail($order));

        // Rediriger vers la page de succès avec le message flash
        return redirect()->route('orders.success', $order->id)
            ->with('success', 'Votre commande a été enregistrée avec succès !');
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return view('orders.show', compact('order'));
    }

    public function success(Order $order)
    {
        $this->authorize('view', $order);
        return view('orders.success', compact('order'));
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }
}