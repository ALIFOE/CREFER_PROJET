@echo off
REM Suppression des fichiers de contrôleurs
cd /d "C:\Users\conce\Desktop\PROJET-N-Don-Energy\CREFER_PROJET"

REM Supprimer les contrôleurs
del /F "app\Http\Controllers\DevisController.php" 2>nul
del /F "app\Http\Controllers\GalleryController.php" 2>nul
del /F "app\Http\Controllers\MarketplaceController.php" 2>nul
del /F "app\Http\Controllers\MediaController.php" 2>nul
del /F "app\Http\Controllers\OrderController.php" 2>nul
del /F "app\Http\Controllers\PaymentController.php" 2>nul
del /F "app\Http\Controllers\CommandeController.php" 2>nul
del /F "app\Http\Controllers\ServiceController.php" 2>nul
del /F "app\Http\Controllers\ServiceRequestController.php" 2>nul
del /F "app\Http\Controllers\Admin\GalleryController.php" 2>nul
del /F "app\Http\Controllers\Admin\FunctionalityController.php" 2>nul
del /F "app\Http\Controllers\Admin\ProductController.php" 2>nul
del /F "app\Http\Controllers\Admin\OrderController.php" 2>nul
del /F "app\Http\Controllers\Admin\ServiceRequestController.php" 2>nul
del /F "app\Http\Controllers\Admin\DevisController.php" 2>nul

REM Supprimer les modèles
del /F "app\Models\Functionality.php" 2>nul
del /F "app\Models\Service.php" 2>nul
del /F "app\Models\DemandeService.php" 2>nul
del /F "app\Models\Devis.php" 2>nul
del /F "app\Models\Product.php" 2>nul
del /F "app\Models\Category.php" 2>nul
del /F "app\Models\Article.php" 2>nul
del /F "app\Models\Tag.php" 2>nul
del /F "app\Models\Order.php" 2>nul
del /F "app\Models\Media.php" 2>nul

REM Supprimer les migrations
del /F "database\migrations\2024_04_16_000001_create_products_table.php" 2>nul
del /F "database\migrations\2025_10_03_163504_create_products_table.php" 2>nul
del /F "database\migrations\2025_05_12_110000_create_devis_table.php" 2>nul
del /F "database\migrations\2025_08_05_000001_ensure_devis_user_association.php" 2>nul
del /F "database\migrations\2025_10_03_163823_create_devis_table.php" 2>nul
del /F "database\migrations\2025_05_08_190226_create_services_table.php" 2>nul
del /F "database\migrations\2025_05_09_204135_add_contact_fields_to_demandes_services.php" 2>nul
del /F "database\migrations\2025_05_09_201110_create_demandes_services_table.php" 2>nul
del /F "database\migrations\2025_05_12_create_media_table.php" 2>nul
del /F "database\migrations\2024_04_16_000002_create_categories_table.php" 2>nul
del /F "database\migrations\2024_04_16_000003_create_articles_table.php" 2>nul
del /F "database\migrations\2024_04_16_000003_create_tags_table.php" 2>nul
del /F "database\migrations\2024_04_16_000002_create_orders_table.php" 2>nul
del /F "database\migrations\2025_10_03_add_category_to_media_table.php" 2>nul

REM Supprimer les dossiers de vues
rmdir /S /Q "resources\views\devis" 2>nul
rmdir /S /Q "resources\views\gallery" 2>nul
rmdir /S /Q "resources\views\services" 2>nul
rmdir /S /Q "resources\views\orders" 2>nul
rmdir /S /Q "resources\views\checkout" 2>nul

REM Supprimer les fichiers de vues
del /F "resources\views\devis.blade.php" 2>nul
del /F "resources\views\fonctionnalite.blade.php" 2>nul
del /F "resources\views\market-place.blade.php" 2>nul
del /F "resources\views\mes-commandes.blade.php" 2>nul
del /F "resources\views\checkout.blade.php" 2>nul
del /F "resources\views\payment-success.blade.php" 2>nul
del /F "resources\views\ia-services.blade.php" 2>nul

REM Nettoyer les dossiers Admin pour les vues supprimées
rmdir /S /Q "resources\views\admin\functionalities" 2>nul
rmdir /S /Q "resources\views\admin\products" 2>nul
rmdir /S /Q "resources\views\admin\devis" 2>nul
rmdir /S /Q "resources\views\admin\orders" 2>nul
rmdir /S /Q "resources\views\admin\services" 2>nul
rmdir /S /Q "resources\views\admin\media" 2>nul

echo.
echo Suppression terminée!
echo.
pause
