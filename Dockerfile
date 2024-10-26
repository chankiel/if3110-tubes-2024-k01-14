FROM php:8.3-apache

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

COPY ./php/src/ /var/www/html/

COPY ./php/php.ini /usr/local/etc/php/

RUN a2enmod rewrite