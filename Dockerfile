# -------------------------
# Stage 1: Build PHP backend
# -------------------------
FROM php:8.2-fpm AS php-base

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    curl \
    zip \
    npm \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip bcmath

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy PHP files
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader
COPY . .

# Generate Laravel key (optional: can also do at runtime)
# RUN php artisan key:generate

# -------------------------
# Stage 2: Build frontend assets
# -------------------------
FROM php-base AS node-build

# Install Node dependencies
RUN npm install
RUN npm install -D sass-embedded
RUN npm run build

# -------------------------
# Stage 3: Final image
# -------------------------
FROM php:8.2-fpm

WORKDIR /var/www/html

# Copy backend from php-base
COPY --from=php-base /var/www/html /var/www/html

# Copy built assets from node-build
COPY --from=node-build /var/www/html/public/build /var/www/html/public/build

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 8000 (or Render default)
EXPOSE 8000

# Start Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
