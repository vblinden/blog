FROM node:22 AS frontend

COPY . /app
WORKDIR /app

RUN npm ci && \
    npm run build

FROM dunglas/frankenphp:latest

RUN install-php-extensions \
	pdo_pgsql \
	intl \
	zip \
	excimer \
	opcache

COPY --from=composer:lts /usr/bin/composer /usr/local/bin/composer

COPY . /app
COPY --from=frontend /app/public /app/public

RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
