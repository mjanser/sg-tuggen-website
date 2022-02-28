COMPOSER_CACHE_DIR ?= $(HOME)/.cache/composer
NAME := $(notdir $(realpath .))
VOLUMES := -v $(PWD):/srv/app:z -v $(COMPOSER_CACHE_DIR):/root/.composer/cache:z -w /srv/app

CONTAINER_IMAGE := localhost/php-$(NAME)

# Dependency to run "composer install" on demand
DEPS :=
ifeq ("$(wildcard ./vendor)", "")
	DEPS := vendor
endif

BASE_RUN := podman run -it --rm $(VOLUMES)
RUN = $(BASE_RUN) --name $(NAME)-$@ --userns=keep-id $(CONTAINER_IMAGE)

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

.PHONY: shell
shell:
	podman exec -it $(NAME) sh

.PHONY: up
up:
	$(BASE_RUN) --name $(NAME) --userns=keep-id --publish 8000:8000 $(CONTAINER_IMAGE)

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
