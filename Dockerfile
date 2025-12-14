# Use official PHP with Apache
FROM php:8.2-apache

# Install required PHP extensions for Laravel
RUN apt-get update && apt-get install -y \
  git unzip libpq-dev libzip-dev zip \
  && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

# Enable Apache mod_rewrite (needed for Laravel routes)
RUN a2enmod rewrite

# Set Apache DocumentRoot to /var/www/html/public (Laravel entry point)
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
 && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

# Copy app code
COPY . /var/www/html/

# Create uploads folder and set permissions
RUN mkdir -p /var/www/html/public/uploads \
  && chown -R www-data:www-data /var/www/html/public/uploads \
  && chmod -R 775 /var/www/html/public/uploads

# Set working dir
WORKDIR /var/www/html

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions for Laravel storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Allow .htaccess overrides for Laravel routing
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Create startup script that uses dynamic PORT
RUN echo '#!/bin/bash\n\
set -e\n\
export PORT=${PORT:-10000}\n\
echo "Starting Apache on port $PORT"\n\
\n\
# Configure Apache port\n\
echo "Listen $PORT" > /etc/apache2/ports.conf\n\
sed -i "s/<VirtualHost \*:[0-9]*>/<VirtualHost *:$PORT>/g" /etc/apache2/sites-available/000-default.conf\n\
\n\
# Set ServerName to suppress warning\n\
echo "ServerName localhost" >> /etc/apache2/apache2.conf\n\
\n\
# Laravel optimizations\n\
cd /var/www/html\n\
php artisan config:cache || true\n\
php artisan route:cache || true\n\
php artisan view:cache || true\n\
\n\
# Start Apache\n\
apache2-foreground' > /usr/local/bin/start.sh && chmod +x /usr/local/bin/start.sh

# Expose PORT (Render will set this dynamically)
EXPOSE $PORT

# Start Apache with dynamic port
CMD ["/usr/local/bin/start.sh"]
