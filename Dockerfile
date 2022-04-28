FROM php:8.0.3-fpm-alpine

RUN apk update && apk add --no-cache git zip postgresql-dev postgresql-client && \
    docker-php-ext-install pdo_pgsql opcache bcmath sockets \
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./.docker/php/php.ini /usr/local/etc/php
WORKDIR /app
COPY ./ .

RUN composer install --optimize-autoloader --no-scripts && rm -rf /root/.composer
RUN chown -R www-data:www-data .
USER www-data

CMD ["php-fpm"]
