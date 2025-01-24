FROM node:18.18.2-alpine AS build-assets

FROM php:8.2-fpm-alpine3.17 AS build-stage

# Ambil file2 node yang ada di image node:**-alpine pindahkan ke image php-fpm, jadi di dalam alpine php fpm ada node js versi 18
# RUN apk add --update nodejs npm
COPY --from=build-assets /usr/lib /usr/lib
COPY --from=build-assets /usr/local/share /usr/local/share
COPY --from=build-assets /usr/local/lib /usr/local/lib
COPY --from=build-assets /usr/local/include /usr/local/include
COPY --from=build-assets /usr/local/bin /usr/local/bin

COPY deploy/php/php.ini /usr/local/etc/php/php.ini
COPY deploy/php/php-fpm.conf  /usr/local/etc/php-fpm.conf
COPY deploy/php/php-fpm.d/www.conf  /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www/

LABEL maintainer="Agung Laksmana <agung.laksmana@sumbarprov.go.id> X Reyan Dirul Adha <reyan@sumbarprov.go.id>"

RUN apk update && apk --no-cache add \
    tzdata \
    nginx \
    build-base \
    libpng-dev \
    libjpeg-turbo-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    oniguruma-dev \
    libxml2-dev \
    freetype-dev \
    nano

# Atur zona waktu ke Jakarta ygy
ENV TZ=Asia/Jakarta

# Copy timezone data dan set localtime ygy
RUN cp /usr/share/zoneinfo/$TZ /etc/localtime && echo "$TZ" > /etc/timezone

# Jalankan perintah date untuk memastikan waktu sudah diatur ygy
RUN date

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/
RUN docker-php-ext-install gd

# Install composer
COPY --from=composer:2.5.1 /usr/bin/composer /usr/bin/composer

#pindah config nginx ke dalam image alpine php fpm
COPY deploy/nginx/ /etc/nginx/
RUN nginx -t

# Buat direktori untuk PID file Nginx
RUN mkdir -p /run/nginx

# buat folder log nginx ganti owner ke www-data dan rubah permission nya ke 755
RUN mkdir -p /var/log/nginx \
    && chown -R www-data:www-data /var/log/nginx \
    && chmod -R 755 /var/log/nginx

# Copy project ke dalam container
COPY . /var/www/

RUN chmod -R 777 /var/www/storage/

RUN cat .env

# Install dependency php
RUN composer install

RUN php artisan storage:link
# install depedency nodejs
RUN npm install

# build css dan js
RUN npm run build

# hapus folder deploy  dan gitlab ciyml
RUN rm -rf /var/www/deploy .gitlab-ci.yml

# rubah permission source code ke root agar tidak bisa dihapus/edit oleh user www-data
RUN chown -R root:root /var/www

# berikan permission ke var lib
RUN chown -R www-data:www-data /var/lib/nginx
RUN chown www-data:www-data /var/run/nginx.pid

# Expose port 9000
EXPOSE 9096

# Script untuk memulai PHP-FPM dan Nginx
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]

# ganti user ke www-data ketika menjalankan container
USER www-data
