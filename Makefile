DOCKER_COMPOSE=docker-compose -f docker/docker-compose.yml

.PHONY: up down restart bash composer install test

up:
	$(DOCKER_COMPOSE) up -d --build

down:
	$(DOCKER_COMPOSE) down

restart:
	$(DOCKER_COMPOSE) down && $(DOCKER_COMPOSE) up -d --build

composer-install:
	$(DOCKER_COMPOSE) run --rm composer install

schema-create:
	$(DOCKER_COMPOSE) exec php php bin/doctrine orm:schema-tool:create

test:
	$(DOCKER_COMPOSE) exec php ./vendor/bin/phpunit

pint:
	$(DOCKER_COMPOSE) run --rm pint