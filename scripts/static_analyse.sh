#!/bin/bash

grn=$'\e[1;32m'
white=$'\e[0m'

echo "${grn}" \
    '
##### CODE SNIFFER ######
' \
    "${white}"
vendor/bin/phpcs -n --standard=phpcs.xml --tab-width=4 -sp

echo "${grn}" \
    '
##### PSALM ######
' \
    "${white}"
vendor/bin/psalm --show-info=true

echo "${grn}" \
    '
##### PHPSTAN ######
' \
    "${white}"
vendor/bin/phpstan --configuration=phpstan.neon
