up:
	docker compose up -d --build

down:
	docker compose down

bash:
	docker compose exec app bash

composer-install:
	docker compose exec app composer install

migrate:
	docker compose exec app php artisan migrate
