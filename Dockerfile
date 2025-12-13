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



# Install Composer //changes

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer



# Install Laravel dependencies

RUN composer install --no-dev --optimize-autoloader



# Set permissions for Laravel storage and cache

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache



# Configure Apache to listen on PORT environment variable (for cloud platforms)

RUN echo "Listen \${PORT:-80}" > /etc/apache2/ports.conf \

  && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:${PORT:-80}>/g' /etc/apache2/sites-available/000-default.conf



# Expose port (cloud platforms will override with PORT env variable)

EXPOSE 80



# Start Apache with environment variable substitution

CMD sed -i "s/80/${PORT:-80}/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf 2>/dev/null; apache2-foreground