FROM php:7.2-cli

RUN apt-get update \
    && apt-get install -y wget git zip zlib1g-dev

RUN docker-php-ext-install zip

RUN wget https://getcomposer.org/composer.phar \
    && chmod +x composer.phar \
    && mv composer.phar /usr/bin/composer
