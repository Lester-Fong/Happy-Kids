# Stage 1: Build Vue frontend
FROM node:14 as node

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build

# Stage 2: Setup Laravel + PHP
FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim unzip git curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    nginx \
    supervisor \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel app files
WORKDIR /var/www
COPY --from=node /app /var/www

# Set correct permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage

# Nginx config
COPY ./nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf

# Supervisor config
COPY ./nginx/supervisord.conf /etc/supervisord.conf

# Expose port
EXPOSE 80

# Start both PHP-FPM and Nginx via Supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
