ARG COMPOSER_NOTLS=false
ARG COMPOSER_VERSION=2
ARG PHP_VERSION
ARG PHPUNIT_CONF=phpunit.xml

FROM composer:${COMPOSER_VERSION} AS composer

FROM php:${PHP_VERSION}-alpine

ARG COMPOSER_NOTLS
ARG PHPUNIT_CONF

COPY --from=composer /usr/bin/composer /usr/local/bin/composer

RUN if [[ "true" == "${COMPOSER_NOTLS}" ]] \
    ; then \
      composer config --global disable-tls true \
      && composer config --global secure-http false \
    ; fi

RUN mkdir /app

WORKDIR /app
ENV PHPUNIT_CONF=${PHPUNIT_CONF}
CMD ["sh", "-c", "composer install && php ./vendor/bin/phpunit --config ${PHPUNIT_CONF}"]
