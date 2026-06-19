#!/bin/sh
set -e

sed -i "s/__PORT__/${PORT:-8080}/g" /etc/nginx/nginx.conf

echo '<?php phpinfo(); ?>' > /var/www/html/public/info.php

APP_KEY=$(grep "^APP_KEY=" /var/www/html/.env | sed 's/APP_KEY=//')
cat > /usr/local/etc/php-fpm.d/env.conf <<EOF
[www]
clear_env = yes
env[APP_KEY] = $APP_KEY
EOF

php artisan migrate --force || echo "Migration failed, will retry on next restart"
php artisan db:seed --force || echo "Seeding failed, will retry on next restart"

php-fpm -D

nginx -g 'daemon off;'
