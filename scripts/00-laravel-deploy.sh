#!/usr/bin/env bash

# Exit immediately if a command exits with a non-zero status
set -e

echo "Starting post-deployment tasks..."

if [ "$DB_FRESH_SEED" = "true" ]; then
    echo "DB_FRESH_SEED is set to true. Running fresh migrations and seeding..."
    php artisan migrate:fresh --force
    php artisan db:seed --force
else
    echo "Running standard migrations..."
    php artisan migrate --force

    # Safe seeding (DatabaseSeeder will skip if users already exist)
    echo "Running database seeders..."
    php artisan db:seed --force
fi

# Cache configuration, routes, and views for optimal performance
echo "Caching configurations..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Caching views..."
php artisan view:cache

echo "Post-deployment tasks completed successfully!"
