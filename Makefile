up:
	docker compose up -d

down:
	docker compose down

build:
	docker compose build

rebuild:
	docker compose down
	docker compose build --no-cache
	docker compose up -d

bash:
	docker compose exec app bash

artisan:
	docker compose exec app php artisan

migrate:
	docker compose exec app php artisan migrate

fresh:
	docker compose exec app php artisan migrate:fresh --seed

tinker:
	docker compose exec app php artisan tinker

test:
	docker compose exec app php artisan test

logs:
	docker compose logs -f

queue:
	docker compose exec app php artisan queue:work

composer:
	docker compose exec app composer install