FROM php:8.4-fpm
RUN apt update
RUN apt install -y git sudo unzip libzip-dev
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN install-php-extensions intl soap bz2 xdebug
RUN install-php-extensions @composer

RUN useradd -m user --uid 1000 -s /usr/bin/bash
RUN echo "user:user" | chpasswd
RUN usermod -aG sudo user

COPY opcache.ini /usr/local/etc/php/conf.d/
COPY custom.ini /usr/local/etc/php/conf.d/

USER user
