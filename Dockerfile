FROM php:7.4-fpm

USER root
RUN apt-get update && apt-get install -y libonig-dev zlib1g-dev libzip-dev unzip git libpq-dev
    # postgresql-client
    #   build-essential locales vim curl
    #   libpng-dev libjpeg62-turbo-dev libfreetype6-dev jpegoptim optipng pngquant gifsicle
    #docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/ && \
    #    docker-php-ext-install gd && \

#RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
#RUN docker-php-ext-install gd

RUN docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt autoremove -y && apt-get clean

RUN groupadd -g 1000 www && useradd -u 1000 -ms /bin/bash -g www www; exit 0
#RUN sed -i 's#^root:#root:$6$aT1zQML59oNobIxj$gy9M/43pIXL5LssIY9W0n7rGyPUF59Ba9l1seJ6jgxZmv/p3gn71id8mAYW6Gbjt3c/NhyzyMKdACJ56Ee8jd.#' /etc/shadow

#ADD ./app/composer.json /app/
#ADD ./app/composer.lock /app/
#ADD ./app/.env /app/

USER www
VOLUME /app
WORKDIR /app

#COPY ./laravel-app/composer.json ./laravel-app/composer.lock ./laravel-app/.env /app/

COPY ./laravel-app /app
COPY --chown=www:www ./laravel-app /app

EXPOSE 9000
CMD ["php-fpm"]

