#!/bin/sh

composer install
php artisan migrate
php artisan db:seed

php-fpm
exec "$@"
