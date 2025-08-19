# ===============================
# Laravel + Vite Dockerfile
# ===============================

# 1️⃣ Base PHP image
FROM php:8.2-fpm

# 2️⃣ Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    npm \
    nodejs \
    && docker-php-ext-install pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# 3️⃣ Set working directory
WORKDIR /var/www/html

# 4️⃣ Copy app source files
COPY . .

# 5️⃣ Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm composer-setup.php

# 6️⃣ Install PHP dependencies (skip scripts to avoid artisan errors)
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# 7️⃣ Optional: Clear caches manually
RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true

# 8️⃣ Install Node dependencies & build assets (skip Sass completely)
RUN npm install
RUN npm run build

# 9️⃣ Set permissions for storage & cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 🔟 Expose port 9000 for PHP-FPM
EXPOSE 9000

# 1️⃣1️⃣ Run PHP-FPM
CMD ["php-fpm"]
