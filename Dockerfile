ARG PHP_VERSION=7.3
ARG WORDPRESS_VERSION=5.1

FROM prooph/composer:${PHP_VERSION} as vendor

WORKDIR /tmp

COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
        --no-autoloader \
        --no-dev \
        --no-interaction \
        --no-scripts \
        --prefer-dist

RUN composer dump-autoload \
        --no-dev \
        --no-interaction \
        --no-scripts \
        --optimize

FROM grottopress/wordpress:${WORDPRESS_VERSION}-php${PHP_VERSION}-fpm-alpine

ENV WORDPRESS_DIR=/var/www/html
ENV JENTIL_DIR=${WORDPRESS_DIR}/wp-content/themes/jentil

COPY --chown=www-data . ${JENTIL_DIR}/
COPY --chown=www-data --from=vendor /tmp/vendor/ ${JENTIL_DIR}/vendor/
