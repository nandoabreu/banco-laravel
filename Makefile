.PHONY: up down

up:
	docker-compose up --remove-orphans -d
	docker-compose exec app php artisan config:cache
	docker-compose exec app php artisan migrate:refresh #--seed
	cd seed && bash seed_wget_create_Clientes.bash

down:
	docker-compose down


default: up

