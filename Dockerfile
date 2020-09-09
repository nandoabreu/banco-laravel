FROM php:7.4-fpm

USER root
RUN apt-get update && apt-get install -y libonig-dev zlib1g-dev libzip-dev unzip git libpq-dev
RUN docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt autoremove -y && apt-get clean

RUN groupadd -g 1000 www && useradd -u 1000 -ms /bin/bash -g www www; exit 0
USER www
VOLUME /app
WORKDIR /app

#COPY ./laravel-app/composer.json ./laravel-app/composer.lock ./laravel-app/.env /app/
COPY ./laravel-app /app
COPY --chown=www:www ./laravel-app /app

EXPOSE 9000
CMD ["php-fpm"]

