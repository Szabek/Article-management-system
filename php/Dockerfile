FROM php:8.2-fpm as app

# Useful PHP extension installer image, copy binary into your container
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Install php extensions and necessary tools
RUN set -eux; \
    apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libzip-dev \
    && install-php-extensions pdo pdo_mysql zip; \
    rm -rf /var/lib/apt/lists/*

# allow super user - set this if you use Composer as a super user at all times like in docker containers
ENV COMPOSER_ALLOW_SUPERUSER=1

# Obtain composer using multi-stage build
COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer

# Copy composer.json and composer.lock
COPY ./app/composer.* ./

# Install dependencies
RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction

# Copy application files to the working directory
COPY ./app .

# Optimize autoload
RUN composer dump-autoload --optimize

# Dev image
FROM app as app_dev

# Xdebug has different modes / functionalities. We can default to 'off' and set to 'debug'
# when we run docker compose up if we need it
ENV XDEBUG_MODE=off

# Copy xdebug config file into container
COPY ./php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Install xdebug
RUN set -eux; \
	install-php-extensions xdebug