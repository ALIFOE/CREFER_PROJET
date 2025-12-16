@echo off
cd /d "C:\Users\conce\Desktop\PROJET-N-Don-Energy\CREFER_PROJET"
echo Exécution des migrations Laravel...
php artisan migrate --force
echo.
echo Migrations terminées !
pause
