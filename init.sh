#!/bin/bash

function check_env {
    file="$1"
    echo "checking $file"

    if [ -f "$file" ]; then
        echo "$file already exists"
        ask_for_permission $file
    else
        echo "creating $file"
        touch $file
    fi
}

function ask_for_permission {
    echo "Do you want to modify the $1 file?  y/n"
    read
    if [ ${REPLY} != "y" ]; then
        echo "Permission not granted. Aborting..."
        exit 0
    fi
}

function propagate_env_file {

    echo "Propagating .env.example file with the following values:"
    ENV_FILE="$1"
    ENV_SAMPLE_FILE="$2"

    if [[ $variables = "" ]]; then
        #load variables from env.example
        while read line; do
            if [[ $line != \#* && $line =~ "=" ]]; then
                echo $line
                variables+=($line)
            fi
        done <$ENV_SAMPLE_FILE
    fi
    #parse through .env.example
    for variable in "${variables[@]}"; do
        VAR=${variable%%=*}
        if grep -Rq $VAR $ENV_FILE; then
            echo $VAR already exists in $ENV_FILE
        else
            if [[ $variable == *"{{"*"}}"* ]]; then
                VAR=${variable##*{{}
                VAR=${VAR%%\}\}*}
                echo ${variable/{{${VAR}\}\}/${!VAR}} >>$ENV_FILE
                echo ${variable/{{${VAR}\}\}/${!VAR}}
            else
                echo $variable >>$ENV_FILE
                echo $variable
            fi
        fi
    done
}

function random_pass {
    local specials="@_+"
    local letters_upper="ABCDEFGHIJKLMNOPQRSTUVWXYZ"
    local letters_lower="abcdefghijklmnopqrstuvwxyz"
    local numbers="0123456789"

    local pass=${letters_upper:$((RANDOM % ${#letters_upper})):2}
    pass+=${specials:$((RANDOM % ${#specials})):1}
    pass+=${numbers:$((RANDOM % ${#numbers})):2}
    pass+=${letters_lower:$((RANDOM % ${#letters_lower})):2}
    pass+=${numbers:$((RANDOM % ${#numbers})):2}
    pass+=${letters_lower:$((RANDOM % ${#letters_lower})):2}

    echo "$pass"
}

function defaulting {
    name="ClubBackend"

    env="$1"
    debug="true"
    network_name="$name"
    api_container_name=$name"_api"

    if [[ $1 = "testing" ]]; then
        db_database="test"
        db_username="root"
    else
        db_database="$name"
        db_username="$name"
    fi

    db_container_name=$name"_db"
    db_host="database"
    db_external_port=3306
    db_username="$name"
    db_password="$2"
    db_connection="mysql"

    phpmyadmin_container_name=$name"_phpmyadmin"
    phpmyadmin_external_port=8081

    mailcatcher_container_name=$name"_mailcatcher"
    mailcatcher_external_http_port=8083
    mailcatcher_external_smtp_port=1025

    nginx_container_name=$name"_nginx"
    nginx_external_port=8082
    nginx_ssl_external_port=443

    redis_container_name=$name"_redis"
    redis_port_external=6379
    redis_host="redis"
}

function main {
    pass=$(random_pass)
    env="local"
    if [[ $1 != "" ]]; then
        env="$1"
    fi
    defaulting $env $pass
    echo ""
    check_env ".env"
    echo ""
    propagate_env_file ".env" ".env.example"
    echo ""

    env_testing="testing"
    defaulting $env_testing $pass
    echo ""
    check_env ".env.testing"
    echo ""
    propagate_env_file ".env.testing" ".env.example"
    echo ""
    exit 0
}

main $1
