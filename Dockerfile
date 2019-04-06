ARG PHP_VERSION=7.3
ARG WP_VERSION=5.1

FROM wordpress:${WP_VERSION}-php${PHP_VERSION}-fpm-alpine

ARG JENTIL_DIR=/var/www/html/wp-content/themes/jentil

ENV JENTIL_DIR=${JENTIL_DIR}

RUN mkdir -p ${JENTIL_DIR}

COPY --chown=www-data . ${JENTIL_DIR}/
