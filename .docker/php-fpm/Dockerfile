FROM php:8.2-fpm

# Update packages
RUN apt-get update && \
    apt-get install -y \
        curl \
        git \
        libfreetype6-dev \
        libicu-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        zip \
        unzip && \
    apt-get install -y default-mysql-client

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd mysqli opcache pdo_mysql zip intl

RUN useradd -ms /bin/bash dilettante

RUN groupmod -o -g ${PGID} dilettante && usermod -o -u ${PUID} -g dilettante dilettante

ADD .docker/php-fpm/entrypoint/docker-entrypoint.sh /opt/docker-entrypoint.sh

# Set working directory
WORKDIR /var/www

# Run composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set recommended PHP settings
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN sed -i 's/memory_limit = .*/memory_limit = 512M/' "$PHP_INI_DIR/php.ini"
RUN sed -i 's/upload_max_filesize = .*/upload_max_filesize = 100M/' "$PHP_INI_DIR/php.ini"
RUN sed -i 's/post_max_size = .*/post_max_size = 100M/' "$PHP_INI_DIR/php.ini"

EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
