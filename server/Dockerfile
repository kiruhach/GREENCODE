FROM php:8.1-cli-alpine

RUN apk add --no-cache postgresql-dev && \
    docker-php-ext-install pdo_pgsql pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --optimize-autoloader --no-dev

RUN php artisan storage:link

EXPOSE $PORT

CMD php artisan migrate --force && \
    php artisan db:seed --force && \
    php artisan serve --host=0.0.0.0 --port=$PORT
