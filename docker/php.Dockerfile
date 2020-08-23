# ----------------------
# Composer install step
# ----------------------
FROM composer:1.7 as build

WORKDIR /app

COPY composer.json composer.json
COPY composer.lock composer.lock
COPY database/ database/

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist


# ----------------------
# The FPM container
# ----------------------
FROM php:7.4-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
#    build-essential \
#    libfreetype6-dev \
#    libjpeg62-turbo-dev \
#    jpegoptim optipng pngquant gifsicle \
#    libpng-dev \
#    locales \
#    zip \
#    nano \
#    unzip \
#    git \
#    curl \
    libzip-dev

RUN docker-php-ext-install -j$(nproc) pdo_mysql zip exif pcntl

WORKDIR /app

COPY ./docker/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY . /app
COPY --from=build /app/vendor/ /app/vendor/

ADD https://github.com/ufoscout/docker-compose-wait/releases/download/2.2.1/wait /wait
RUN chmod +x /wait

## Launch the wait tool
CMD /wait && php artisan key:generate && php artisan migrate && php-fpm

VOLUME /app
