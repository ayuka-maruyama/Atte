FROM php:8.0-fpm

COPY php.ini /usr/local/etc/php/

RUN apt update \
  && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip cron \
  && docker-php-ext-install pdo_mysql zip \
  && curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
  && composer self-update \
  && rm -rf /var/lib/apt/lists/*

COPY crontab /etc/cron.d/laravel-cron

RUN chmod 0644 /etc/cron.d/laravel-cron \
    && crontab /etc/cron.d/laravel-cron

WORKDIR /var/www

CMD ["sh", "-c", "cron && php-fpm"]