#!/usr/bin/env sh
set -e

# Give proper permissions to storage and cache directories
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Create storage symlink for public files
php artisan storage:link || true

# Clear caches, then rebuild config so runtime environment variables are read
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan config:cache

# Start Apache in foreground
# (CMD di Dockerfile tidak membawa argumen, jadi "exec $@" tidak menjalankan apa-apa)
exec apache2-foreground
