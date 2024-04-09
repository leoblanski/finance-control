FROM php:8.2-fpm-alpine

ARG WORKDIR
WORKDIR $WORKDIR

RUN apk update && \
    apk add --update linux-headers && \
    apk add --no-cache util-linux \
    bash \
    git \
    curl \
    vim \
    nano \
    curl-dev \
    libxml2-dev \
    tzdata \
    icu-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libxpm-dev \
    zlib-dev \
    libtool \
    libzip-dev \
    build-base \
    autoconf

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-stable \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install mysqli pdo pdo_mysql bcmath sockets curl soap pcntl\
    && docker-php-ext-enable soap pcntl \
    && docker-php-ext-install intl

COPY --from=composer:2.5.4 /usr/bin/composer /usr/local/bin/composer

# Add a non-root user to prevent files being created with root permissions on host machine.
ARG PUID=1001
ENV PUID 1001
ARG PGID=1001
ENV PGID 1001

RUN addgroup -g ${PGID} docker && \
    adduser -D -u ${PUID} -G docker docker

USER docker

CMD ["php-fpm"]
