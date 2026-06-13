up:
	docker compose up -d --build

down:
	docker compose down

bash:
	docker compose exec --user dev app bash

composer-install:
	docker compose exec app composer install

migrate:
	docker compose exec app php artisan migrate

new:
	# Create Laravel in a temporary directory and copy into the project to avoid "directory not empty" errors
	docker compose exec --user dev app bash -lc "composer create-project laravel/laravel /tmp/laravel '^13.0' --prefer-dist --no-interaction && bash -lc 'shopt -s dotglob && cp -a /tmp/laravel/. /var/www/html/' && rm -rf /tmp/laravel && composer install || true && php artisan key:generate || true"
