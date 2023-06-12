FROM php:8.2-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

RUN apk add --update nodejs npm

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

