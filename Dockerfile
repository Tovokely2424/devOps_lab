FROM php:8.2-fpm

RUN  apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    unzip \
    curl \
    git \
    libpng-dev \
    libonig-dev \
    libjpeg-dev \
    libxml2-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql mbstring exif

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install

# Donne les bons droits
RUN chown -R www-data:www-data /var/www/var


EXPOSE 9000

CMD ["php-fpm"]
