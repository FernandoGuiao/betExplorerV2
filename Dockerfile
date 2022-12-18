FROM php:8.1-fpm


# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

CMD php artisan serve --host=0.0.0.0 --port=8000

USER $user
