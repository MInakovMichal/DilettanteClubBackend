#!/bin/bash
set -e

function fix_permissions() {
  pushd /var/www
    chown -R $USER:$USER *
    chmod -R 777 storage bootstrap/cache
  popd
}

function clear_cache() {
  pushd /var/www
    rm -Rf bootstrap/cache/*.php
    rm -Rf storage/framework/cache/data/*.php
    php artisan optimize:clear
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
    php artisan cache:clear
    php artisan clear-compiled
  popd
}

function run_seed() {
    pushd /var/www
      php artisan db:seed --force
      php artisan --env=testing db:seed --force
    popd
}

function run_migration() {
   pushd /var/www
    php artisan migrate --force
    php artisan --env=testing migrate --force
   popd
}

function prepare_basic_dependency() {
  pushd /var/www
   php artisan storage:link
   php artisan key:generate
   yes | php artisan jwt:secret

   php artisan --env=testing key:generate
   yes | php artisan --env=testing jwt:secret
  popd
}

function install_dependencies() {
  pushd /var/www
   composer install
  popd
}

function generate_api_doc() {
  pushd /var/www
     php artisan scribe:generate
  popd
}

echo "Start container configuration... Please wait 30 seconds."
CONTAINER_FIRST_STARTUP="CONTAINER_FIRST_STARTUP"
/bin/sleep 30
if [ ! -e /$CONTAINER_FIRST_STARTUP ]; then
  touch /$CONTAINER_FIRST_STARTUP
  install_dependencies
  fix_permissions
  clear_cache
  prepare_basic_dependency
  run_migration
  run_seed
  clear_cache
else
  install_dependencies
  fix_permissions
  clear_cache
  run_migration
  clear_cache
fi
generate_api_doc
fix_permissions

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
  set -- php "$@"
fi

exec php-fpm
