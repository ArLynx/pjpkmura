FROM php:8.3-apache

# 1. Install all system dependencies and tools in one layer to keep image small
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev libpng-dev libjpeg-dev libfreetype6-dev nano npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

COPY ./docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

# 2. Grab Composer from the official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Copy application files
COPY . /var/www/html

# 4. Allow Composer to run as root during build
ENV COMPOSER_ALLOW_SUPERUSER=1

# 5. Install dependencies and build assets
RUN composer install --no-interaction --optimize-autoloader
RUN npm install
RUN npm run build

# 6. Set correct Laravel permissions last
RUN chmod -R 777 storage bootstrap/cache
RUN php artisan storage:link || true
