FROM php:8.0-fpm

RUN pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    apt-get update && apt-get install -y zlib1g-dev git zip && \
    docker-php-ext-install pdo_mysql opcache && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer
