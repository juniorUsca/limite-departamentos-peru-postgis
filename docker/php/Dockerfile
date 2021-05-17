FROM php:7.4-fpm
# FROM php:7-apache
# COPY www.conf /usr/local/etc/php-fpm.d/www.conf
# RUN a2enmod rewrite

RUN apt update -y && apt install -y libpq-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql pgsql pdo_pgsql

RUN apt-get install -y libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev \
    libfreetype6-dev
RUN apt-get update && \
    apt-get install -y \
        zlib1g-dev

# RUN docker-php-ext-install mbstring

RUN apt-get install -y libzip-dev
RUN docker-php-ext-install zip

# RUN docker-php-ext-configure gd --with-gd --with-webp-dir --with-jpeg-dir \
#    --with-png-dir --with-zlib-dir --with-xpm-dir --with-freetype-dir \

RUN apt-get install -y \
libfreetype6-dev libjpeg62-turbo-dev \
libgd-dev libpng-dev
RUN docker-php-ext-configure gd \
--with-jpeg \
--with-freetype

RUN docker-php-ext-install gd

# RUN docker-php-ext-install gd

