COMPOSER_CACHE_DIR ?= $(HOME)/.cache/composer
COMPOSER_CONFIG_DIR ?= $(HOME)/.config/composer
NAME := $(notdir $(realpath .))
VOLUMES := -v $(PWD):/srv/app:z -v $(COMPOSER_CACHE_DIR):/root/.composer/cache:z -v $(COMPOSER_CONFIG_DIR):/root/.composer/config:z -w /srv/app

CONTAINER_IMAGE := localhost/php-$(NAME)

# Dependency to run "composer install" on demand
DEPS :=
ifeq ("$(wildcard ./vendor)", "")
	DEPS := vendor
endif

SSH_ARGS := -v $(SSH_AUTH_SOCK):/root/.ssh-agent/local-socket -e SSH_AUTH_SOCK=/root/.ssh-agent/local-socket

BASE_RUN := podman run -it --rm $(VOLUMES) $(SSH_ARGS)
RUN = $(BASE_RUN) --name $(NAME)-$@ $(CONTAINER_IMAGE)

.PHONY: build
build:
	podman build --pull -t $(CONTAINER_IMAGE) .

composer.lock: vendor
vendor: composer-install

.PHONY: composer-install
composer-install:
	$(RUN) composer install

.PHONY: phpstan
phpstan: $(DEPS)
	$(RUN) composer phpstan

.PHONY: cs-fix
cs-fix: $(DEPS)
	$(RUN) composer cs:fix

.PHONY: cs-diff
cs-diff: $(DEPS)
	$(RUN) composer cs:diff

.PHONY: up
up:
	$(BASE_RUN) --name $(NAME) --publish 8000:8000 $(CONTAINER_IMAGE)

.PHONY: shell
shell:
	podman exec -it $(NAME) sh

.PHONY: deploy
deploy:
	podman exec -it $(NAME) vendor/bin/deployer.phar deploy

.PHONY: cmd
cmd:
	@echo $(RUN)

.PHONY: run
run:
	$(RUN) $(ARGS)

.PHONY: run-simple
run-simple: run

.PHONY: clean
clean:
	-rm -rf build
	-rm -r .php-cs-fixer.cache

.PHONY: clean-all
clean-all: clean
	-rm -rf vendor/
