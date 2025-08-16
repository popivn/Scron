FROM php:8.2-apache

# Enable Apache modules
RUN a2enmod rewrite headers expires

# Copy app source
COPY . /var/www/html/

# Permissions for Apache user
RUN chown -R www-data:www-data /var/www/html

# Expose HTTP port
EXPOSE 80

# Default command provided by base image
# CMD ["apache2-foreground"]

