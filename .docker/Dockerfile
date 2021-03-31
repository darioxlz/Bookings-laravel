# base image
FROM php:7.4.16-apache
# root privileges
USER root
WORKDIR /clubdata-api


# apt-get
RUN apt-get update
RUN apt-get -y install bzip2 vim wget zip unzip libpq-dev
RUN apt-get -y install libmcrypt-dev libzip-dev zziplib-bin zlib1g-dev


# docker-php ext-install
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo pdo_pgsql pgsql

# composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./composer.json ./composer.json
COPY ./composer.lock ./composer.lock

RUN composer install --no-dev --no-interaction --no-scripts


# tell apache where is the folder to serve
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# copy laravel project to WORKDIR
COPY . ./

# copy script to run after create container
COPY .docker/docker-php-entrypoint /usr/local/bin/
RUN chmod 755 /usr/local/bin/docker-php-entrypoint

RUN chown -R www-data:www-data ./ && a2enmod rewrite
RUN chown -R www-data:www-data storage
