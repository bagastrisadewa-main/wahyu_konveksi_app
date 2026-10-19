#!/usr/bin/env sh
set -e

# Give proper permissions to storage and cache directories
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Create storage symlink for public files (Laravel storage:link)
php artisan storage:link || true

# Clear and rebuild config cache so that new environment variables are read
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan config:cache

# Run the original command (Apache in foreground)
exec "$@"
