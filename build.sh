#!/usr/bin/env bash
# exit on error
set -o errexit

echo "Installing composer dependencies..."
composer install --no-dev --optimize-autoloader

echo "Preparing database..."
touch database/database.sqlite

echo "Running migrations and seeders..."
php artisan migrate:fresh --force --seed

echo "Optimizing configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache