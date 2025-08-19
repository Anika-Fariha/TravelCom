# ------------------------
# Stage 1: Build Frontend
# ------------------------
FROM node:18 AS frontend

# Set working directory
WORKDIR /app

# Copy package files and install
COPY package*.json vite.config.* ./
RUN npm install

# Copy source files
COPY resources ./resources
COPY public ./public

# Build assets
RUN npm run build


# ------------------------
# Stage 2: Build PHP/Laravel
# ------------------------
FROM php:8.2-apache AS backend

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev zip curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Enable Apache rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy Laravel backend files
COPY . .

# Copy frontend build from Stage 1
COPY --from=frontend /app/public/build ./public/build

# Install PHP dependencies (optimize for production)
RUN composer install --no-dev --optimize-autoloader

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose Apache port
EXPOSE 80

# Run Apache
CMD ["apache2-foreground"]
