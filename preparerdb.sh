#!/bin/sh
echo " Creation de la base de données : gestionformations"
php artisan db:create

echo "Running database migrations"
./migrations.sh

echo "Creation de l'admin"
php artisan backoffice:user
