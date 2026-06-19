FROM php:8.1-cli-alpine

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
    sed -i 's/SESSION_DOMAIN=greencode/SESSION_DOMAIN=/' .env && \
    sed -i 's/APP_URL=.*/APP_URL=/' .env && \
    sed -i 's/SANCTUM_STATEFUL_DOMAINS=.*/SANCTUM_STATEFUL_DOMAINS=/' .env

RUN composer install --optimize-autoloader --no-dev

RUN php artisan key:generate

RUN php artisan storage:link

EXPOSE $PORT

CMD php artisan migrate --force && \
    php artisan db:seed --force && \
    php artisan serve --host=0.0.0.0 --port=$PORT
