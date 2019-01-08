FROM wordpress:fpm-alpine

ENV JENTIL_DIR=/var/www/html/wp-content/themes/jentil

RUN mkdir -p ${JENTIL_DIR}

COPY . ${JENTIL_DIR}
