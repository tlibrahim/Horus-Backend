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

logs:
	docker compose logs -f

queue:
	docker compose exec app php artisan queue:work

composer:
	docker compose exec app composer install

lint:
	docker compose exec app ./vendor/bin/pint --test

fix:
	docker compose exec app ./vendor/bin/pint

test:
	docker compose exec app php artisan test

stan:
	docker compose exec app ./vendor/bin/phpstan analyse --memory-limit=1G

ci: lint test stan