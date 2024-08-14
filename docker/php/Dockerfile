FROM php:7.4.9-fpm

COPY php.ini /usr/local/etc/php/

RUN apt update \
  && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip cron \
  && docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
  && composer self-update

COPY crontab /etc/cron.d/laravel-cron

RUN chmod 0644 /etc/cron.d/laravel-cron \
  && crontab /etc/cron.d/laravel-cron

CMD ["sh", "-c", "cron && php-fpm"]

WORKDIR /var/www