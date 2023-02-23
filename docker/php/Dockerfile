FROM php:8.1-fpm
USER root

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    build-essential \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev \
    libfreetype6 \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    sudo

RUN apt-get install -y supervisor
ADD  /docker/php/supervisord.conf /etc/supervisor/supervisord.conf
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install gd
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN pecl install mongodb && docker-php-ext-enable mongodb
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-webp=/usr/include/  --with-jpeg=/usr/include/

CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]
