FROM php:8.1-fpm-alpine AS build

RUN apk add --no-cache \
        postgresql-dev \
        libxml2-dev \
        oniguruma-dev \
        zip \
        curl-dev \
    && docker-php-ext-install \
        pdo_pgsql \
        pdo_mysql \
        mbstring \
        xml \
        bcmath \
        ctype \
        fileinfo \
        curl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN cp .env.example .env && \
    sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=pgsql/' .env && \
    sed -i 's/SESSION_DOMAIN=.*/SESSION_DOMAIN=/' .env && \
    sed -i 's/APP_URL=.*/APP_URL=/' .env && \
    sed -i 's/SANCTUM_STATEFUL_DOMAINS=.*/SANCTUM_STATEFUL_DOMAINS=/' .env

RUN chmod -R 777 storage bootstrap/cache

RUN composer install --optimize-autoloader --no-dev

RUN php artisan key:generate

RUN php artisan storage:link

FROM php:8.1-fpm-alpine

RUN apk add --no-cache nginx \
    && sed -i 's/^clear_env = yes/clear_env = no/' /usr/local/etc/php-fpm.d/www.conf

COPY --from=build /var/www/html /var/www/html

COPY nginx.conf.template /etc/nginx/nginx.conf
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

RUN chmod +x /usr/local/bin/docker-entrypoint.sh

WORKDIR /var/www/html

EXPOSE $PORT

ENTRYPOINT ["docker-entrypoint.sh"]
