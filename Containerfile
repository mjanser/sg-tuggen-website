# Base PHP image
FROM php:8.3-cli-alpine AS base

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

WORKDIR /usr/src/app

RUN apk add --no-cache \
	acl \
	bash \
	bash-completion \
	file \
	gettext \
	git \
	openssh-client \
	;

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash; \
	apk add --no-cache \
	symfony-cli \
	;

# php extensions installer: https://github.com/mlocati/docker-php-extension-installer
COPY --from=ghcr.io/mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN set -eux; \
	install-php-extensions \
	@composer \
	apcu \
	intl \
	opcache \
	pcntl \
	zip \
	;

ENV PHP_INI_SCAN_DIR=":$PHP_INI_DIR/app.conf.d"

COPY config/php/conf.d/10-app.ini $PHP_INI_DIR/app.conf.d/

RUN addgroup -g ${GID} --system php && adduser -G php --system -D -u ${UID} php && chown -R php:php /usr/src/app
USER php

RUN echo 'eval "$(/srv/app/bin/console completion bash)"' >> ~/.bashrc

###> recipes ###
###< recipes ###

# Dev PHP image
FROM base AS php_dev

ENV APP_ENV=dev XDEBUG_MODE=off
USER root

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN set -eux; \
	install-php-extensions \
	xdebug \
	;

COPY config/php/conf.d/20-app.dev.ini $PHP_INI_DIR/app.conf.d/

USER php

EXPOSE 8000
CMD ["symfony", "server:start", "--no-tls", "--allow-all-ip"]

# Prod PHP image
FROM base AS php_prod

ENV APP_ENV=prod
USER root

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY config/php/conf.d/20-app.prod.ini $PHP_INI_DIR/app.conf.d/

VOLUME /usr/src/app/var/

USER php

# prevent the reinstallation of vendors at every changes in the source code
COPY composer.* symfony.* ./
RUN set -eux; \
	composer install --no-cache --prefer-dist --no-dev --no-autoloader --no-scripts --no-progress

# copy sources
USER root
COPY . ./
RUN rm -Rf config/php

RUN set -eux; \
	mkdir -p var/cache var/log; \
	composer dump-autoload --classmap-authoritative --no-dev; \
	composer dump-env prod; \
	composer run-script --no-dev post-install-cmd; \
	chmod +x bin/console; sync;

USER php
