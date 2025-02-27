FROM php:8.2.16-fpm as php-fpm

ARG TZ=ASIA/TEHRAN

RUN ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime  && echo ${TZ} > /etc/timezone

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    libpq-dev \
    libgd-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libavif-dev \
    libwebp-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libxml2-dev \
    supervisor \
    curl \
    git \
    procps \
    ffmpeg

RUN mkdir -p /usr/src/php/ext/redis \
    && curl -L https://github.com/phpredis/phpredis/archive/refs/tags/6.0.2.tar.gz -o phpredis.tar.gz \
    && tar xzf phpredis.tar.gz --strip 1 -C /usr/src/php/ext/redis \
    && rm phpredis.tar.gz

RUN docker-php-ext-configure gd --prefix=/usr --with-freetype --with-webp --with-jpeg --with-avif
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql zip redis gd opcache pcntl soap

# RUN pecl install swoole pcov && docker-php-ext-enable swoole pcov

COPY /docker/php/php.ini /usr/local/etc/php/php.ini
COPY /docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

RUN curl -sSLo /usr/bin/supercronic https://github.com/aptible/supercronic/releases/download/v0.2.29/supercronic-linux-amd64 \
  && chmod +x /usr/bin/supercronic \
  && mkdir -p /etc/supercronic \
  && echo "*/1 * * * * php /var/www/artisan schedule:run --verbose --no-interaction" > /etc/supercronic/laravel

FROM php-fpm as vendor

WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY /composer* ./

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install \
  --no-interaction \
  --prefer-dist \
  --ignore-platform-reqs \
  --optimize-autoloader \
  --apcu-autoloader \
  --ansi \
  --no-scripts \
  --audit

FROM php-fpm as production

WORKDIR /var/www

COPY / .
COPY --from=vendor /var/www/vendor vendor
COPY --from=vendor /var/www/composer.lock composer.lock
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY /docker/php/supervisord* /etc/supervisor/conf.d/
COPY "docker/php/entrypoint.sh" /usr/local/bin/entrypoint.sh

RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8000

ENTRYPOINT ["entrypoint.sh"]

