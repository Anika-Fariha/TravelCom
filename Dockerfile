# 1️⃣ Use PHP base image with required extensions
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

# 4️⃣ Copy composer.json and install PHP dependencies
COPY composer.json composer.lock ./
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader
RUN rm composer-setup.php

# 5️⃣ Copy the rest of the app
COPY . .

# 6️⃣ Install Node dependencies
RUN npm install

# 7️⃣ Build assets (empty CSS now, so safe)
RUN npm run build

# 8️⃣ Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 9️⃣ Expose port 9000 and run PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]
