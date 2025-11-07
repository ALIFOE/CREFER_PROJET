<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\Devis;
use App\Models\ServiceRequest;
use App\Models\Formation;
use App\Models\FormationInscription;
use App\Models\User;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmationMail;
use App\Mail\AdminOrderNotificationMail;
use App\Mail\DevisConfirmationMail;
use App\Mail\AdminDevisNotificationMail;
use App\Mail\ServiceRequestConfirmationMail;
use App\Mail\AdminServiceRequestNotificationMail;
use App\Mail\FormationConfirmationMail;
use Illuminate\Support\Facades\Log;

class TestEmailNotificationsCommand extends Command
{
    protected $signature = 'test:notifications';
    protected $description = 'Teste l\'envoi des emails de notification pour toutes les sections';

    public function handle()
    {
        $this->info('Début des tests d\'envoi d\'emails...');

        // Création d'un produit de test si nécessaire
        $product = Product::firstOrCreate(
            ['name' => 'Produit Test'],
            [
                'description' => 'Produit pour test des notifications',
                'price' => 50000,
                'stock' => 10
            ]
        );

        // Test Commande
        $this->testOrderEmails($product);

        // Test Devis
        $this->testDevisEmails();

        // Test Service
        $this->testServiceEmails();

        // Test Formation
        $this->testFormationEmails();

        $this->info('Tests terminés !');
    }

    private function testOrderEmails($product)
    {
        $this->info('Test des emails de commande...');
        
        try {
            $order = Order::create([
                'product_id' => $product->id,
                'quantity' => 1,
                'total_price' => $product->price,
                'status' => 'pending',
                'payment_method' => 'carte',
                'customer_name' => 'Client Test',
                'customer_email' => 'test@example.com',
                'customer_phone' => '0123456789',
                'customer_address' => 'Adresse de test'
            ]);

            // Email client
            Mail::to($order->customer_email)->send(new OrderConfirmationMail($order));
            
            // Email admin
            Mail::to(User::getAdminEmails())->send(new AdminOrderNotificationMail($order));

            $this->info('✓ Emails de commande envoyés avec succès');
            
        } catch (\Exception $e) {
            $this->error('× Erreur lors du test des emails de commande: ' . $e->getMessage());
            Log::error('Test notification commande échoué', ['error' => $e->getMessage()]);
        }
    }

    private function testDevisEmails()
    {
        $this->info('Test des emails de devis...');
        
        try {
            $devis = Devis::create([
                'nom' => 'Client Test',
                'prenom' => 'Prénom Test',
                'email' => 'test@example.com',
                'telephone' => '0123456789',
                'adresse' => 'Adresse de test',
                'type_batiment' => 'Maison',
                'consommation_annuelle' => 5000,
                'type_toiture' => 'Tuiles',
                'orientation' => 'Sud',
                'objectifs' => ['Réduction facture', 'Écologie'],
                'message' => 'Message de test'
            ]);

            // Email client
            Mail::to($devis->email)->send(new DevisConfirmationMail($devis));
            
            // Email admin
            Mail::to(User::getAdminEmails())->send(new AdminDevisNotificationMail($devis));

            $this->info('✓ Emails de devis envoyés avec succès');
            
        } catch (\Exception $e) {
            $this->error('× Erreur lors du test des emails de devis: ' . $e->getMessage());
            Log::error('Test notification devis échoué', ['error' => $e->getMessage()]);
        }
    }

    private function testServiceEmails()
    {
        $this->info('Test des emails de service...');
        
        try {
            $service = Service::firstOrCreate(
                ['nom' => 'Service Test'],
                ['description' => 'Service pour test des notifications']
            );

            $serviceRequest = ServiceRequest::create([
                'service_id' => $service->id,
                'nom' => 'Client Test',
                'email' => 'test@example.com',
                'telephone' => '0123456789',
                'adresse' => 'Adresse de test',
                'description' => 'Description de test',
                'status' => 'pending'
            ]);

            // Email client
            Mail::to($serviceRequest->email)->send(new ServiceRequestConfirmationMail($serviceRequest));
            
            // Email admin
            Mail::to(User::getAdminEmails())->send(new AdminServiceRequestNotificationMail($serviceRequest));

            $this->info('✓ Emails de service envoyés avec succès');
            
        } catch (\Exception $e) {
            $this->error('× Erreur lors du test des emails de service: ' . $e->getMessage());
            Log::error('Test notification service échoué', ['error' => $e->getMessage()]);
        }
    }

    private function testFormationEmails()
    {
        $this->info('Test des emails de formation...');
        
        try {
            $formation = Formation::firstOrCreate(
                ['titre' => 'Formation Test'],
                [
                    'description' => 'Formation pour test des notifications',
                    'date_debut' => now()->addDays(30),
                    'duree' => '3 jours',
                    'lieu' => 'Lieu de test',
                    'prix' => 75000
                ]
            );

            $inscription = FormationInscription::create([
                'formation_id' => $formation->id,
                'nom' => 'Client Test',
                'email' => 'test@example.com',
                'telephone' => '0123456789',
                'statut' => 'en_attente'
            ]);

            // Email client
            Mail::to($inscription->email)->send(new FormationConfirmationMail($inscription));

            $this->info('✓ Emails de formation envoyés avec succès');
            
        } catch (\Exception $e) {
            $this->error('× Erreur lors du test des emails de formation: ' . $e->getMessage());
            Log::error('Test notification formation échoué', ['error' => $e->getMessage()]);
        }
    }
}