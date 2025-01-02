FROM php:8.1.5-fpm-alpine3.14

RUN apk update && apk upgrade

RUN apk add --no-cache zip unzip curl sqlite nginx supervisor

RUN apk add bash

RUN apk add --no-cache mysql-client

RUN rm -rf /var/lib/apt

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN apk update

RUN apk add autoconf

RUN apk update && apk upgrade \
&& apk add --no-cache \
bash \
zip \
unzip \
curl \
sqlite \
mysql-client \
supervisor \
libxml2-dev \
icu-dev \
oniguruma-dev \
gmp-dev \
libpng-dev \
libjpeg-turbo-dev \
libwebp-dev \
freetype-dev \
autoconf \
build-base \
openssl-dev \
zlib-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
&& docker-php-ext-install -j$(nproc) soap bcmath gmp pdo pdo_mysql intl opcache gd mbstring \
&& docker-php-ext-enable soap bcmath gmp pdo pdo_mysql intl opcache gd mbstring

EXPOSE 9000
CMD ["php-fpm"]
