FROM php:7.4-fpm-alpine

RUN apk --no-cache update \
    && apk add zlib-dev \
    && apk add nodejs-npm \
    && rm -rf /var/cache/apk/*

RUN docker-php-ext-install pdo_mysql

# composerをインストール
COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY php.ini /usr/local/etc/php/

WORKDIR /var/www/html
