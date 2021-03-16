FROM composer:2.0 as composer

FROM php:7.4-fpm

RUN apt-get update && \
    apt-get install -y \
    git

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/app

COPY --chown=1001:1001 . /var/www/app

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer install --no-scripts --prefer-dist \
  && rm -rf "$(composer config cache-dir)" "$(composer config data-dir)"