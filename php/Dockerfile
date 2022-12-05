FROM php:8.0.22-fpm-alpine

RUN apk --update add tzdata && \
    cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime && \
    apk del tzdata && \
    rm -rf /var/cache/apk/*

RUN apk --update add oniguruma-dev && \
    rm -rf /var/cache/apk/*

RUN apk --update add libzip-dev \
    &&  docker-php-ext-install zip

RUN apk --update add git

RUN docker-php-ext-install pdo pdo_mysql mysqli mbstring && \
    docker-php-ext-install -j$(nproc) pdo_mysql

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd xdebug

COPY php.ini-development /usr/local/etc/php/php.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer global require phpoffice/phpspreadsheet

WORKDIR /work

CMD ["php", "-S", "0.0.0.0:8000", "-t", "/work/public"]