FROM wordpress:fpm-alpine

ARG JENTIL_DIR=/var/www/html/wp-content/themes/jentil

ENV JENTIL_DIR=${JENTIL_DIR}

RUN mkdir -p ${JENTIL_DIR}

COPY . ${JENTIL_DIR}
