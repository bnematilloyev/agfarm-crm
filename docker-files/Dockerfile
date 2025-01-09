FROM php:8.2-fpm

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN apt-get update && apt-get install -y git

RUN chmod +x /usr/local/bin/install-php-extensions && sync && install-php-extensions gd zip soap pdo_pgsql exif

ADD ./php.ini /usr/local/etc/php/conf.d/40-custom.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u 1000 -d /home/deployer deployer
RUN mkdir -p /home/deployer/.composer && \
    chown -R deployer:deployer /home/deployer

WORKDIR /var/www/app

USER deployer

CMD ["php-fpm"]
