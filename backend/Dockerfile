FROM php:8.3-cli

WORKDIR /app
COPY . .

RUN apt-get update && apt-get install -y \
    unzip git curl libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=$PORT
