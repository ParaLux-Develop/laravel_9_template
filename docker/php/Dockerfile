FROM php:8.1.11-fpm-alpine3.16

# tinker(psysh)
ARG PSYSH_DIR=/usr/local/share/psysh
ARG PHP_MANUAL_URL=http://psysh.org/manual/ja/php_manual.sqlite

# timezone
ARG TZ

# composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer

RUN set -eux && \
  apk update && \
  apk add --update --no-cache --virtual=.build-dependencies \
  autoconf \
  gcc \
  g++ \
  make \
  tzdata \
  git && \
  apk add --update --no-cache \
  icu-dev \
  oniguruma-dev \
  supervisor=~4.2\
  libzip-dev && \
  cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime && \
  echo ${TZ} > /etc/timezone && \
  # pecl install xdebug && \
  git clone https://github.com/phpredis/phpredis.git /usr/src/php/ext/redis && \
  apk del .build-dependencies && \
  docker-php-ext-install intl pdo_mysql mbstring zip bcmath redis && \
  # docker-php-ext-enable xdebug && \
  # mkdir $PSYSH_DIR && wget $PHP_MANUAL_URL -P $PSYSH_DIR && \
  curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
# composer config -g repos.packagist composer https://packagist.jp
# composer global require hirak/prestissimo
CMD ["ash", "-c", "composer install && supervisord -c /etc/supervisord.conf && php-fpm " ]
