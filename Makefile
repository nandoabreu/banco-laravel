.PHONY: build up down

build:
	docker-compose up --build --remove-orphans -d | grep Step
	docker-compose exec app php artisan config:cache
	docker-compose exec app php artisan migrate:refresh #--seed
	cd seed && bash seed_wget_create_Clientes.bash && cd -

up:
	docker-compose up --remove-orphans -d

down:
	docker-compose down


default: up

