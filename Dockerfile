# Stage 1: Build Assets using Node.js
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# Stage 2: PHP Application and Web Server
FROM richarvey/nginx-php-fpm:3.1.6

# Install PostgreSQL dev library and driver
RUN apk add --no-cache postgresql-dev \
    && docker-php-ext-install pdo_pgsql

# Set work directory
WORKDIR /var/www/html

# Copy composer files first for caching
COPY composer.json composer.lock ./

# Allow Composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Install composer dependencies (no scripts, no autoloader yet)
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy application files
COPY . .

# Copy compiled assets from node-builder
COPY --from=node-builder /app/public/build ./public/build

# Finish composer autoload and run post-autoload scripts
RUN composer dump-autoload --no-dev --classmap-authoritative

# Image configuration for richarvey/nginx-php-fpm
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel environment defaults
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

EXPOSE 80

CMD ["/start.sh"]
