FROM composer:1.9 AS composer

WORKDIR /app

RUN docker-php-ext-install pdo pdo_mysql \
    && mkdir -p /usr/src/php/ext/redis \
    && curl -L https://github.com/phpredis/phpredis/archive/5.0.0.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
    && echo 'redis' >> /usr/src/php-available-exts \
    && docker-php-ext-install redis

COPY . .

RUN composer install

FROM php:7.3.3-fpm-alpine AS phpfpm

RUN docker-php-ext-install pdo pdo_mysql \
    && mkdir -p /usr/src/php/ext/redis \
    && curl -L https://github.com/phpredis/phpredis/archive/5.0.0.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
    && echo 'redis' >> /usr/src/php-available-exts \
    && docker-php-ext-install redis

COPY --from=composer /app /var/www/html

WORKDIR /var/www/html

