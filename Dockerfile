FROM php:7.3.1-apache

RUN apt-get -qq update && \
    apt-get install -y --allow-unauthenticated git ssh curl libpq-dev libmemcached-dev zlib1g-dev libzip-dev libcurl4-openssl-dev libicu-dev libxml2-dev && \
    pecl install redis && \
    docker-php-ext-enable redis && \
    docker-php-ext-install intl curl zip mbstring

RUN curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

WORKDIR /var/www