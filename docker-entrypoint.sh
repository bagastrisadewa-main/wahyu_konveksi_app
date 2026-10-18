#!/bin/bash
set -e

# Buat symbolic link storage jika belum ada
php artisan storage:link || true

# Bersihkan cache lama
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Pastikan permission storage & cache aman
mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache || true
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache || true

# Jalankan Apache
exec apache2-foreground
