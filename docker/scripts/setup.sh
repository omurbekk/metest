#!/usr/bin/env bash

CURRENT_DIR=$(pwd)

DOCKER_COMPOSE_PATH="/usr/local/bin/docker-compose"

if [ ! -x "$DOCKER_COMPOSE_PATH" ]; then
    echo "Ошибка: docker-compose не установлен или не найден. Пожалуйста, установите Docker Compose."
    exit 1
fi

"$DOCKER_COMPOSE_PATH" -f "${CURRENT_DIR}/docker-compose.yml" up -d --build

"$DOCKER_COMPOSE_PATH" exec app composer install

"$DOCKER_COMPOSE_PATH" exec app php bin/console doctrine:database:create
"$DOCKER_COMPOSE_PATH" exec app php bin/console doctrine:schema:create --no-interaction
"$DOCKER_COMPOSE_PATH" exec app php bin/console doctrine:fixtures:load --no-interaction
