FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y \
        git \
        unzip \
        libzip-dev \
        && docker-php-ext-install zip pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENTRYPOINT ["./docker-entrypoint.sh"]