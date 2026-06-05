#!/usr/bin/env bash

# Exit immediately if a command exits with a non-zero status
set -e

echo "Starting post-deployment tasks..."

# Run database migrations
echo "Running migrations..."
php artisan migrate --force

# Run database seeders (safely guarded against rewriting existing data)
echo "Running database seeders..."
php artisan db:seed --force

# Cache configuration, routes, and views for optimal performance
echo "Caching configurations..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Caching views..."
php artisan view:cache

echo "Post-deployment tasks completed successfully!"
