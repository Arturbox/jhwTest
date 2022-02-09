FROM composer:2.0.9 AS composer

FROM php:8.0.11-fpm AS base

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    git \
    libgmp-dev \
    libicu-dev \
    libzip-dev \
    unzip \
    zlib1g \
    zlib1g-dev

RUN docker-php-ext-install sockets

RUN docker-php-ext-configure intl \
 && docker-php-ext-install zip pdo pdo_mysql intl gmp opcache pcntl \
 && docker-php-ext-enable opcache \
 && docker-php-ext-enable sockets

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY contrib/php/opcache.ini /usr/local/etc/php/conf.d

WORKDIR /var/www

ENV PATH="$PATH:/var/www/vendor/bin"

ARG CACHEBUST=1
# Install dependencies
COPY composer.json ./
RUN composer install --prefer-dist --no-scripts --no-dev --no-autoloader && echo "${CACHEBUST}"

COPY --from=spiralscout/roadrunner:2.6.3 /usr/bin/rr /usr/bin/rr

FROM base AS dev

ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="1"
ENV PHP_OPCACHE_ENABLE_CLI="1"

COPY . ./

RUN composer update && echo "${CACHEBUST}"
RUN composer dump-autoload

EXPOSE 9000
CMD ["php-fpm"]
