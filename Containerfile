FROM php:8.0-cli-alpine

RUN apk add --no-cache \
        acl \
        fcgi \
        file \
        gettext \
        git \
        gnu-libiconv \
        openssh-client \
    ;

# install gnu-libiconv and set LD_PRELOAD env to make iconv work fully on Alpine image.
# see https://github.com/docker-library/php/issues/240#issuecomment-763112749
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so

ARG APCU_VERSION=5.1.21
RUN set -eux; \
    apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        icu-dev \
        libzip-dev \
        zlib-dev \
    ; \
    wget https://github.com/symfony-cli/symfony-cli/releases/download/v5.7.3/symfony-cli_5.7.3_x86_64.apk && \
        apk add --no-cache --allow-untrusted symfony-cli*.apk && rm symfony-cli*.apk \
    ; \
    \
    docker-php-ext-configure zip; \
    docker-php-ext-install -j$(nproc) \
        intl \
        zip \
    ; \
    pecl install \
        apcu-${APCU_VERSION} \
    ; \
    pecl clear-cache; \
    docker-php-ext-enable \
        apcu \
        opcache \
    ; \
    \
    runDeps="$( \
        scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
            | tr ',' '\n' \
            | sort -u \
            | awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
    )"; \
    apk add --no-cache --virtual .phpexts-rundeps $runDeps; \
    \
    apk del .build-deps

RUN ln -s $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

ENV HOME=/root

WORKDIR /srv/app

###> recipes ###
###< recipes ###

EXPOSE 8000
CMD ["symfony", "server:start", "--no-tls"]
