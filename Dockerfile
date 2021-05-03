ARG PHP_VERSION

FROM php:${PHP_VERSION}-alpine

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync \
 && install-php-extensions \
    @composer \
 && mkdir /app

WORKDIR /app
CMD ["sh", "-c", "composer install && php ./vendor/bin/phpunit --config phpunit.xml"]
