# Backend (Laravel 13)

This repository contains a scaffold for a Laravel 13 application using Docker and PostgreSQL.

Quickstart (uses Docker):

1. Copy `.env.example` to `.env` and adjust values if needed.
2. Build and start the containers:

```bash
docker compose up --build -d
```

3. Enter the app container and create the Laravel project (if not already present):

```bash
docker compose exec app bash
# inside container
composer create-project laravel/laravel=. "^13.0" --prefer-dist --no-interaction
php artisan key:generate
php artisan migrate
```

4. Visit http://localhost:8080

Files included:
- `docker-compose.yml` - app, postgres, adminer, nginx
- `Dockerfile` - PHP-FPM image with Composer
- `nginx/default.conf` - nginx configuration
- `.env.example` - environment example
- `.github/workflows/ci.yml` - basic CI workflow
- `Makefile` - helper tasks

Notes:
- PHP version pinned to a recent stable release; change `Dockerfile` to update.
- PostgreSQL is used as the DB; adjust credentials in `.env`.

Enjoy!
