include .env
export

UID=$(shell id -u)
GID=$(shell id -g)
DOCKER_PHP_SERVICE=xtags_php
DOCKER_WORKERS_SERVICE=xtags_php_workers

export UID := ${UID}

fresh-start: erase build up composer-install sleep init
	docker-compose run --rm --no-deps -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} console lexik:jwt:generate-keypair --skip-if-exists

erase:
	-docker-compose down -v --remove-orphans;
	-truncate -s 0 ./var/log/*.log

prune: erase
	docker system prune --volumes
	docker image prune --all

cache-folders:
	-mkdir -p ~/.composer
	-sudo chown -R ${UID}:${GID} ~/.composer
	-mkdir -p var/cache var/log
	-sudo chown -R ${UID}:${GID} var/cache var/log && sudo chmod -R ug+s var/cache

build: cache-folders
	-docker pull mlocati/php-extension-installer
	docker-compose build --build-arg UID=${UID} --build-arg GID=${GID}  && \
	docker-compose pull

composer-install:
	docker-compose run --rm --no-deps -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} /usr/local/bin/composer install --ignore-platform-reqs -o

init:
	docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} console ximdex:environment:init

up:
	docker-compose up -d

stop:
	docker-compose stop

shell:
	docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} sh

shell-root:
	docker-compose run --rm ${DOCKER_PHP_SERVICE} sh

shell-workers:
	docker-compose exec ${DOCKER_WORKERS_SERVICE} sh

restart-workers:
	docker-compose exec ${DOCKER_WORKERS_SERVICE} sh -c "supervisorctl reread && supervisorctl restart all"

stop-workers:
	docker-compose exec ${DOCKER_WORKERS_SERVICE} supervisorctl stop all

migrate:
	docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} console migrations:migrate

logs:
	docker-compose logs -f ${DOCKER_PHP_SERVICE}

cs-fix-modified:
	docker-compose exec -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} phpcbf $$(git --no-pager diff --name-only --diff-filter=ACM HEAD -- | grep '.php$$')

sleep:
	sync
	sleep 5

user-create-test:
	docker-compose exec -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} console xtags:user:register test@ximdex.local Ximdex Test ROLE_XIMDEX_API --password=secret --user-id=deadbeef-cafe-f00d-babe-c001e57b00b5
