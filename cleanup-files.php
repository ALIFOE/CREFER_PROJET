<?php
// Script pour supprimer les fichiers concernant services, boutique, devis, fonctionnalités

$baseDir = __DIR__;

$filesToDelete = [
    // Controllers
    'app/Http/Controllers/DevisController.php',
    'app/Http/Controllers/GalleryController.php',
    'app/Http/Controllers/MarketplaceController.php',
    'app/Http/Controllers/MediaController.php',
    'app/Http/Controllers/OrderController.php',
    'app/Http/Controllers/PaymentController.php',
    'app/Http/Controllers/CommandeController.php',
    'app/Http/Controllers/ServiceController.php',
    'app/Http/Controllers/ServiceRequestController.php',
    'app/Http/Controllers/Admin/GalleryController.php',
    'app/Http/Controllers/Admin/FunctionalityController.php',
    'app/Http/Controllers/Admin/ProductController.php',
    'app/Http/Controllers/Admin/OrderController.php',
    'app/Http/Controllers/Admin/ServiceRequestController.php',
    'app/Http/Controllers/Admin/DevisController.php',
    'app/Http/Controllers/Client/DemandeServiceController.php',
];

$dirsToDelete = [
    // Models
    'app/Models/Functionality.php',
    'app/Models/Service.php',
    'app/Models/DemandeService.php',
    'app/Models/Devis.php',
    'app/Models/Product.php',
    'app/Models/Category.php',
    'app/Models/Article.php',
    'app/Models/Tag.php',
    'app/Models/Order.php',
    'app/Models/Commande.php',
    'app/Models/Media.php',
];

foreach ($filesToDelete as $file) {
    $path = $baseDir . '/' . $file;
    if (file_exists($path)) {
        unlink($path);
        echo "✓ Supprimé: $file\n";
    } else {
        echo "✗ Non trouvé: $file\n";
    }
}

foreach ($dirsToDelete as $file) {
    $path = $baseDir . '/' . $file;
    if (file_exists($path)) {
        unlink($path);
        echo "✓ Supprimé: $file\n";
    } else {
        echo "✗ Non trouvé: $file\n";
    }
}

echo "\nSuppression terminée!\n";
