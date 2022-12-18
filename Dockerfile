FROM php:8.1.0RC1-fpm-alpine
EXPOSE 9000
# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apk update && apk install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip


# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

RUN php artisan serve --host=0.0.0.0 --port=9000

# Set working directory
WORKDIR /var/www

USER $user
