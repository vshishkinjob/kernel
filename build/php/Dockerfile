FROM php:8.2.9-apache

WORKDIR /var/www

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN pecl install redis && docker-php-ext-enable redis

RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql pgsql

RUN apt-get install -y libssh2-1-dev libssh2-1 \
    && pecl install ssh2-1.3.1 \
    && docker-php-ext-enable ssh2

RUN docker-php-ext-install sockets && docker-php-ext-enable sockets

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip

RUN docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install pcntl

RUN apt-get update && \
    apt-get install -y graphviz

RUN apt-get -y update \
    && apt-get install -y libicu-dev\
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git

RUN apt-get update && \
    apt-get install wget

RUN mkdir /excel_library && \
    git clone https://github.com/Jan-E/php_excel.git -b php7_with_pulls /excel_library

RUN wget -P /excel_library http://www.libxl.com/download/libxl-lin-3.8.1.tar.gz && \
    tar xvfz /excel_library/libxl-lin-3.8.1.tar.gz --directory=/excel_library

RUN cd /excel_library && phpize && \
    ./configure --with-libxl-incdir=/excel_library/libxl-3.8.1.0/include_c --with-libxl-libdir=/excel_library/libxl-3.8.1.0/lib64 && \
    make install


RUN a2enmod headers
RUN a2enmod rewrite
RUN service apache2 restart


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
