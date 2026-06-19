#!/bin/sh
set -e

sed -i "s/__PORT__/${PORT:-8080}/g" /etc/nginx/nginx.conf

echo '<?php phpinfo(); ?>' > /var/www/html/public/info.php

php artisan migrate --force || echo "Migration failed, will retry on next restart"
php artisan db:seed --force || echo "Seeding failed, will retry on next restart"

php-fpm -D

nginx -g 'daemon off;'
