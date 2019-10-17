FROM php:7.3-apache

RUN docker-php-ext-install mysqli pdo_mysql bcmath sockets pcntl
RUN apt-get update && apt-get install -y nano wget

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer