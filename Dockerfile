FROM php:8.0.3-fpm-alpine

RUN apk add ldb-dev libldap openldap-dev libxml2-dev curl supervisor
RUN set -ex && apk --no-cache add libxml2-dev
RUN apk update && apk add --no-cache git zip postgresql-dev && \
    docker-php-ext-install pdo_pgsql opcache bcmath sockets ldap soap pcntl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./.docker/php/php.ini /usr/local/etc/php
WORKDIR /app

CMD ["php-fpm"]
