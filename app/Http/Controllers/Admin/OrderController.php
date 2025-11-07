<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Mail\OrderStatusUpdatedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $orders = Order::with('product', 'user')
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $oldStatus = $order->status;
        
        $order->update([
            'status' => $validatedData['status']
        ]);

        try {
            // Envoyer l'email au client
            Mail::to($order->customer_email)->send(new OrderStatusUpdatedMail($order));
            
            return redirect()->back()
                ->with('success', 'Le statut de la commande a été mis à jour et le client a été notifié par email.');
        } catch (\Exception $e) {
            // En cas d'erreur d'envoi d'email
            return redirect()->back()
                ->with('success', 'Le statut de la commande a été mis à jour.')
                ->with('error', 'L\'email de notification n\'a pas pu être envoyé : ' . $e->getMessage());
        }
    }
}