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
RUN mkdir -p /var/www/html/public/uploads/vehicles \
  && chown -R www-data:www-data /var/www/html/public/uploads \
  && chmod -R 775 /var/www/html/public/uploads

# Set working dir
WORKDIR /var/www/html

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set composer environment variables for better stability
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_NO_INTERACTION=1
ENV COMPOSER_MEMORY_LIMIT=-1
ENV COMPOSER_PROCESS_TIMEOUT=600
ENV COMPOSER_HTACCESS_PROTECT=0

# Clear any existing composer cache and install dependencies
RUN rm -rf /root/.composer/cache/* && \
    composer clear-cache && \
    composer install --no-dev --optimize-autoloader --no-scripts --prefer-dist --no-cache || \
    (echo "First attempt failed, retrying with cache clear..." && \
     rm -rf vendor/ composer.lock && \
     composer clear-cache && \
     composer install --no-dev --optimize-autoloader --no-scripts --prefer-dist --no-cache)

# Set permissions for Laravel storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
  && chmod -R 775 /var/www/html/storage \
  && chmod -R 775 /var/www/html/bootstrap/cache \
  && mkdir -p /var/www/html/storage/framework/sessions \
  && mkdir -p /var/www/html/storage/framework/cache \
  && mkdir -p /var/www/html/storage/framework/views \
  && chmod -R 775 /var/www/html/storage/framework

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
# Ensure storage directories exist with correct permissions\n\
mkdir -p /var/www/html/storage/framework/sessions\n\
mkdir -p /var/www/html/storage/framework/cache/data\n\
mkdir -p /var/www/html/storage/framework/views\n\
mkdir -p /var/www/html/storage/logs\n\
chown -R www-data:www-data /var/www/html/storage\n\
chmod -R 775 /var/www/html/storage\n\
\n\
# Laravel optimizations\n\
cd /var/www/html\n\
php artisan config:clear || true\n\
php artisan cache:clear || true\n\
php artisan route:clear || true\n\
php artisan view:clear || true\n\
# Only cache if APP_KEY is set\n\
if [ ! -z "$APP_KEY" ]; then\n\
  php artisan config:cache || true\n\
  php artisan route:cache || true\n\
  php artisan view:cache || true\n\
else\n\
  echo "WARNING: APP_KEY not set, skipping config cache"\n\
fi\n\
\n\
# Start Apache\n\
apache2-foreground' > /usr/local/bin/start.sh && chmod +x /usr/local/bin/start.sh

# Expose PORT (Render will set this dynamically)
EXPOSE $PORT

# Start Apache with dynamic port
CMD ["/usr/local/bin/start.sh"]
