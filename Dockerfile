# 1️⃣ Use PHP base image
FROM php:8.2-fpm

# 2️⃣ Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    curl \
    npm \
    nodejs \
    && docker-php-ext-install pdo_mysql zip

# 3️⃣ Set working directory
WORKDIR /var/www/html

# 4️⃣ Copy the whole app first
COPY . .

# 5️⃣ Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm composer-setup.php

# 6️⃣ Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# 7️⃣ Optional: Clear caches manually
RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true

# 8️⃣ Install Node dependencies & build
RUN npm install
RUN npm run build

# 9️⃣ Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 🔟 Expose port and run
EXPOSE 9000
CMD ["php-fpm"]
