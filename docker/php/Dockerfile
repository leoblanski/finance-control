FROM php:8.2-fpm-alpine

ARG WORKDIR
WORKDIR $WORKDIR

# Update and install necessary packages
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
    && docker-php-ext-install mysqli pdo pdo_mysql bcmath sockets curl soap zip pcntl gd \
    && docker-php-ext-enable soap pcntl gd \
    && docker-php-ext-install zip \
    && docker-php-ext-install intl

COPY --from=composer:2.5.4 /usr/bin/composer /usr/local/bin/composer

# Create a new user called appuser
RUN addgroup -g 1001 appuser && \
    adduser -D -u 1001 -G appuser appuser

# Switch to the appuser
USER appuser

# Copy the rest of the application code into the container
COPY --chown=appuser:appuser . $WORKDIR

USER $user

RUN chown -R appuser:appuser $WORKDIR

CMD ["php-fpm"]
