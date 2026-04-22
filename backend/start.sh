#!/bin/sh
set -eu

echo "Starting Laravel on Render..."
echo "PORT=${PORT:-10000}"

mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache
chmod -R 775 storage bootstrap/cache || true

php artisan config:clear
php artisan route:clear
php artisan view:clear

if [ -n "${APP_KEY:-}" ]; then
  echo "APP_KEY is set."
else
  echo "APP_KEY is missing."
fi

if [ -n "${MYSQLHOST:-}" ] || [ -n "${DB_HOST:-}" ] || [ -n "${DB_URL:-}" ]; then
  echo "Database variables detected. Running migrations..."
  php artisan migrate --force
else
  echo "No database variables detected. Skipping migrations."
fi

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
