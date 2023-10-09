include .env

up:
	docker compose up -d
stop:
	docker compose stop
down:
	docker compose down
build:
	docker compose build
destroy:
	docker compose down --volumes --remove-orphans
destroy-all:
	docker compose down --rmi all --volumes --remove-orphans
remake:
	@make down
	@make install
	@make migrate
	@make seed
	@make cache
	@make minio
install:
	@make build
	@make up
	@make composer
restart:
	@make down
	@make up
ps:
	docker compose ps
logs:
	docker compose logs
mysql:
	docker compose exec mysql bash
test:
	docker compose exec -e APP_ENV=testing app bash -c 'php artisan test $(TEAMCITY_REPORT)'
composer:
	docker compose exec app bash -c 'composer install'
migrate:
	docker compose exec app bash -c 'php artisan migrate --force'
seed:
	docker compose exec app bash -c 'php artisan db:seed --force'
cache:
	docker compose exec app bash -c 'php artisan cache:clear'
minio:
	docker compose exec minio bash -c 'mc config host add laravel http://localhost:9000 ${MINIO_ROOT_USER} ${MINIO_ROOT_PASSWORD}'
	docker compose exec minio bash -c 'mc mb laravel/local --ignore-existing'
