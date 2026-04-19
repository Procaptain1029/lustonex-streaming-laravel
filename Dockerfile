# syntax=docker/dockerfile:1

# -----------------------------------------------------------------------------
# PHP dependencies
# -----------------------------------------------------------------------------
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-interaction --ignore-platform-reqs
COPY . .
RUN composer dump-autoload --optimize --classmap-authoritative --no-interaction

# -----------------------------------------------------------------------------
# Vite / frontend build (required for @vite in Blade)
# -----------------------------------------------------------------------------
FROM node:20-bookworm-slim AS frontend
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY --from=vendor /app /app
RUN npm run build

# -----------------------------------------------------------------------------
# Runtime: nginx + libnginx-mod-rtmp + PHP 8.1-FPM + Redis (phpredis) + Supervisor
# Set CONTAINER_ROLE=worker on Render Worker services to run queue:work only.
# -----------------------------------------------------------------------------
FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive \
    PORT=10000 \
    CONTAINER_ROLE=web \
    RUN_MIGRATIONS=0 \
    RUN_STORAGE_LINK=1 \
    CACHE_CONFIG=0 \
    REDIS_CLIENT=phpredis

RUN apt-get update && apt-get install -y --no-install-recommends \
    nginx \
    libnginx-mod-rtmp \
    php8.1-fpm \
    php8.1-cli \
    php8.1-pgsql \
    php8.1-redis \
    php8.1-sqlite3 \
    php8.1-xml \
    php8.1-mbstring \
    php8.1-curl \
    php8.1-zip \
    php8.1-gd \
    php8.1-bcmath \
    php8.1-intl \
    gettext-base \
    supervisor \
    curl \
    ca-certificates \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build

RUN cp docker/supervisord.conf /etc/supervisor/supervisord.conf \
    && sed -i 's/^;daemonize = yes/daemonize = no/' /etc/php/8.1/fpm/pool.d/www.conf \
    && mkdir -p /var/log/supervisor public/hls/live \
    && chown -R www-data:www-data storage bootstrap/cache public/hls \
    && chmod +x docker/entrypoint.sh

EXPOSE 10000 1935

ENTRYPOINT ["/var/www/html/docker/entrypoint.sh"]
