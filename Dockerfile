FROM php:8.2-apache

# Install dépendances système + extensions PostgreSQL (tu utilises pgsql)
RUN apt-get update && apt-get install -y \
    git unzip zip libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Activer rewrite (important pour Laravel routes)
RUN a2enmod rewrite

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copie le code
COPY . .

# Install dépendances
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Permissions Laravel
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Changer DocumentRoot vers /public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

# Expose le port Apache
EXPOSE 80

# Lancement (migrations en runtime via Render si tu veux, ou ici si build ok)
CMD php artisan migrate --force --no-interaction ; \
    php artisan config:cache ; \
    apache2-foreground
