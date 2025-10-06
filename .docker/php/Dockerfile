FROM php:${PHP_VERSION:-8.4.13-fpm}-alpine${ALPINE_VERSION:-3.22}

RUN apk add --no-cache \
    curl \
    git \
    unzip \
    icu-dev \
    libxml2-dev \
    zlib-dev \
    oniguruma-dev \
    libzip-dev \
    gd-dev

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    intl \
    mbstring \
    zip \
    xml \
    ctype \
    opcache \
    gd
# Setup Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/eva
