containerName := "sgtuggen"
containerImageName := "localhost/sg-tuggen-website"

default:
    @just --list --justfile {{ justfile() }}

# Builds the container image
build *options:
    podman build --tag {{ containerImageName }} --env UID=${UID:-1000} --env GID=${GID:-1000} --target php_dev .

# Rebuilds the container image
rebuild: (build "--pull" "--no-cache")

# Starts the container
up:
    podman run -it --rm --detach --userns keep-id -v ${PWD}:/srv/app:z -v ${COMPOSER_CACHE_DIR}:/root/.composer/cache:z -v ${COMPOSER_CONFIG_FILE}:/root/.composer/config/config.json:z -v ${COMPOSER_AUTH_FILE}:/root/.composer/config/auth.json:z -w /srv/app --name {{ containerName }} --publish 8000:8000 {{ containerImageName }}

# Stops the running container
down:
    podman stop {{ containerName }}

logs:
    podman logs --follow {{ containerName }}

shell:
    podman exec -it {{ containerName }} bash

composer-normalize-check: (composer "normalize --dry-run")
composer-normalize-fix: (composer "normalize")
cs-check: (composer "cs:check")
cs-fix: (composer "cs:fix")
phpstan: (composer "phpstan:check")
rector-check: (composer "rector:check")
rector-fix: (composer "rector:fix")
phpunit *options: (composer "phpunit:check --" options)
coverage *options: (composer "phpunit:coverage:html --" options)

# Execute all CI tasks by fixing code
ci-fix: composer-normalize-fix cs-fix phpstan rector-fix phpunit
ci-fix-coverage: composer-normalize-fix cs-fix phpstan rector-fix coverage

# Execute all CI tasks
ci-check: composer-normalize-check cs-check phpstan rector-check phpunit
ci-check-coverage: composer-normalize-check cs-check phpstan rector-check coverage

composer +options:
    podman exec -ti {{ containerName }} composer {{ options }}

console *command:
    podman exec -ti {{containerName }} bin/console {{ command }}

deploy:
    podman exec -it {{ containerName }} vendor/bin/dep deploy
