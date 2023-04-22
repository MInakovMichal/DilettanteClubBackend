#!/bin/sh

# shellcheck disable=SC2164

php artisan --env=testing migrate
php artisan --env=testing db:seed
