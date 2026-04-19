#!/bin/bash
set -euo pipefail

export PORT="${PORT:-10000}"
CONTAINER_ROLE="${CONTAINER_ROLE:-web}"

cd /var/www/html

mkdir -p public/hls/live storage/framework/{sessions,views,cache} storage/logs bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache public/hls

if [[ "$CONTAINER_ROLE" == "worker" ]]; then
    if [[ "${RUN_MIGRATIONS:-0}" == "1" ]]; then
        php artisan migrate --force
    fi
    exec php artisan queue:work "${QUEUE_CONNECTION:-redis}" --sleep=3 --tries=3 --max-time=3600 --verbose
fi

if [[ "${RUN_STORAGE_LINK:-1}" == "1" ]] && [[ ! -L public/storage ]]; then
    php artisan storage:link --force || true
fi

if [[ "${RUN_MIGRATIONS:-0}" == "1" ]]; then
    php artisan migrate --force
fi

if [[ "${CACHE_CONFIG:-0}" == "1" ]]; then
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

envsubst '$PORT' < /var/www/html/docker/nginx/nginx.conf.template > /etc/nginx/nginx.conf
nginx -t

exec /usr/bin/supervisord -c /etc/supervisor/supervisord.conf
