FROM php:8.3.13-fpm-alpine

RUN apk add --no-cache \
    zlib-dev \
    curl \
    g++ \
    git \
    build-base \
    icu-dev \
    zip \
    libzip-dev \
    libpq-dev \
    bash \
    sudo \
    postgresql-dev \
    oniguruma-dev \
    autoconf \
    && docker-php-ext-install intl opcache pdo pdo_pgsql pgsql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

WORKDIR /var/www/project

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash --
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony