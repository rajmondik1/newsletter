FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        zlib1g-dev g++ git libicu-dev zip libzip-dev zip gcc make autoconf \
        libc-dev pkg-config libssl-dev \
    && docker-php-ext-install intl opcache pdo pdo_mysql

RUN apt-get update \
    && apt-get install -y \
        librabbitmq-dev \
        libssh-dev \
    && docker-php-ext-install \
        bcmath \
        sockets \
    && pecl install amqp \
    && docker-php-ext-enable amqp

RUN pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

WORKDIR /var/www/project

# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN curl -sS https://get.symfony.com/cli/installer | bash

