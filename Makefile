container=app

init:
	cp .env.example .env
	docker-compose up -d
	docker-compose exec $(container) composer install
	docker-compose exec $(container) php artisan key:generate
	docker-compose exec $(container) php artisan migrate

up:build
	docker-compose up -d

down:
	docker-compose down

build:
	docker-compose build

test:
	docker-compose exec $(container) vendor/bin/phpunit tests

composer:
	docker-compose exec $(container) composer $(CMD)

.PHONY: artisan
artisan:
	docker-compose exec $(container) php artisan $(CMD)

tinker:
	docker-compose exec $(container) php artisan tinker

helper:
	docker-compose exec $(container) php artisan ide-helper:generate
	docker-compose exec $(container) php artisan ide-helper:models
	docker-compose exec $(container) php artisan ide-helper:meta
