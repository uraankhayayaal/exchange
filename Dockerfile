FROM --platform=linux/amd64 yiisoftware/yii2-php:8.3-fpm
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libtool \
    libzip-dev \
    libpng-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    imagemagick \
    libmagickwand-dev
RUN docker-php-ext-configure pcntl --enable-pcntl && \
    docker-php-ext-install \
    pdo \
    pdo_mysql \
    pcntl
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin
COPY ./php.ini /usr/local/etc/php/conf.d/base.ini
WORKDIR /app
ENTRYPOINT ["docker-php-entrypoint"]
CMD ["/bin/bash", "./startup.sh"]