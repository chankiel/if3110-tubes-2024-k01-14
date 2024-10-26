# Dockerfile
FROM php:8.3-apache

# Install PostgreSQL PDO driver
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copy the application files
COPY ./php/src/ /var/www/html/

# Enable mod_rewrite
RUN a2enmod rewrite