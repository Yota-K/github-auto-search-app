FROM php:7.4-fpm-alpine

RUN apk --no-cache update \
  && apk add zlib-dev nodejs-npm gcc autoconf build-base \
  && rm -rf /var/cache/apk/* \
  && pecl install redis \
  && docker-php-ext-install pdo_mysql pcntl \
  && docker-php-ext-enable redis

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY php.ini /usr/local/etc/php/

WORKDIR /var/www/html
