ARG PHP_VERSION=7.4
ARG WORDPRESS_VERSION=6.1

FROM prooph/composer:${PHP_VERSION} AS vendor

WORKDIR /tmp

COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer update \
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

FROM wordpress:${WORDPRESS_VERSION}-php${PHP_VERSION}-fpm-alpine

ENV WORDPRESS_DIR=/var/www/html
ENV JENTIL_DIR=${WORDPRESS_DIR}/wp-content/themes/jentil

COPY --chown=www-data . /usr/src/jentil/
COPY --chown=www-data --from=vendor /tmp/vendor/ /usr/src/jentil/vendor/
COPY docker/docker-entrypoint.sh /tmp/

RUN cat /usr/local/bin/docker-entrypoint.sh | \
        sed '/^\s*exec "$@"/d' > \
        /usr/local/bin/docker-jentil-entrypoint.sh; \
    cat /tmp/docker-entrypoint.sh >> \
        /usr/local/bin/docker-jentil-entrypoint.sh; \
    chmod +x /usr/local/bin/docker-jentil-entrypoint.sh

ENTRYPOINT ["docker-jentil-entrypoint.sh"]

CMD ["php-fpm"]
