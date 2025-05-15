#!/bin/sh
set -e

cd /app

php artisan optimize

exec "$@"

