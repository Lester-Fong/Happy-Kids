# Stage 1: Build frontend
FROM node:14 AS node

WORKDIR /app

COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Set up Laravel backend
FROM php:7.4-fpm AS app

RUN apt-get update && apt-get install -y \
    nginx supervisor unzip curl git \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libonig-dev libxml2-dev libzip-dev zip \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel app
WORKDIR /var/www
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Build Laravel caches
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Copy Nginx config
COPY ./nginx/render.conf /etc/nginx/conf.d/default.conf

# Expose port 80
EXPOSE 80

# Start supervisord to run both Nginx and PHP-FPM
COPY ./render-supervisord.conf /etc/supervisord.conf
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
