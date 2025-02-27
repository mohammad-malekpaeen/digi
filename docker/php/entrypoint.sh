#!/bin/sh
sleep 5

ENV_FILE="/var/www/.env"

get_env_var() {
    # shellcheck disable=SC2039
    local var_name=$1
    grep "^$var_name=" "$ENV_FILE" | cut -d '=' -f2
}

if [ ! -f /var/www/.env ]; then
    echo "Creating env"
    cd /var/www/
    cp .env.example .env
fi

if [ -z "$(get_env_var 'APP_KEY')" ]; then
    echo "Generating app key"
    php artisan config:clear
    php artisan config:cache
    php artisan key:generate
fi


chown -R www-data:www-data storage bootstrap/cache /var/www/.env
php artisan cache:clear
php artisan config:clear
php artisan optimize:clear
php artisan migrate --force --seed

php artisan vendor:publish --tag="melipayamak"
php artisan vendor:publish --tag=telescope-assets
php artisan vendor:publish --tag=horizon-assets
php artisan vendor:publish --tag=pulse-dashboard
php artisan geoip:update

php artisan package:discover --ansi
php artisan config:cache
php artisan optimize


chmod -R 775 /var/www/storage/logs /var/www/storage/app/public /var/www/bootstrap/cache /var/www/.env

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
