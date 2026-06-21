# ─── Stage 1: Build frontend assets ──────────────────────
FROM node:20-slim AS frontend

WORKDIR /var/www/html

COPY package.json package-lock.json* ./
RUN npm install

COPY resources/ ./resources/
COPY vite.config.js ./
COPY public/ ./public/

RUN npm run build

# ─── Stage 2: Production PHP image ───────────────────────
FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# System dependencies
RUN apk add --no-cache \
    nginx \
    postgresql-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    supervisor \
    && docker-php-ext-install pdo pdo_pgsql pgsql gd zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy app files
COPY --chown=www-data:www-data . .

# Copy built assets from frontend stage
COPY --from=frontend --chown=www-data:www-data /var/www/html/public/build/ ./public/build/

# Install PHP dependencies (no dev)
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && chown -R www-data:www-data /var/www/html

# Storage permissions
RUN mkdir -p storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    storage/app/public \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Storage symlink (created at runtime in entrypoint)

# Nginx config
RUN echo 'server { \
    listen 80; \
    server_name _; \
    root /var/www/html/public; \
    index index.php; \
    charset utf-8; \
    location / { try_files $uri $uri/ /index.php?$query_string; } \
    location = /favicon.ico { access_log off; log_not_found off; } \
    location = /robots.txt { access_log off; log_not_found off; } \
    error_page 404 /index.php; \
    location ~ \.php$ { \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name; \
        include fastcgi_params; \
    } \
    location ~ /\\.(?!well-known).* { deny all; } \
}' > /etc/nginx/http.d/default.conf

# Supervisor config — run nginx + php-fpm
RUN echo '[supervisord]' > /etc/supervisord.conf && \
    echo 'nodaemon=true' >> /etc/supervisord.conf && \
    echo '' >> /etc/supervisord.conf && \
    echo '[program:nginx]' >> /etc/supervisord.conf && \
    echo 'command=nginx -g "daemon off;"' >> /etc/supervisord.conf && \
    echo 'autostart=true' >> /etc/supervisord.conf && \
    echo 'autorestart=true' >> /etc/supervisord.conf && \
    echo '' >> /etc/supervisord.conf && \
    echo '[program:php-fpm]' >> /etc/supervisord.conf && \
    echo 'command=php-fpm' >> /etc/supervisord.conf && \
    echo 'autostart=true' >> /etc/supervisord.conf && \
    echo 'autorestart=true' >> /etc/supervisord.conf

# Render uses PORT env var
ENV PORT=80

EXPOSE 80

# Entrypoint: ensure APP_KEY has base64: prefix, migrate, seed, cache, start
CMD if [ -n "$APP_KEY" ] && [ "${APP_KEY#base64:}" = "$APP_KEY" ]; then \
        export APP_KEY="base64:$APP_KEY"; \
    fi && \
    php artisan storage:link || true && \
    php artisan migrate --force && \
    php artisan db:seed --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    supervisord -c /etc/supervisord.conf
