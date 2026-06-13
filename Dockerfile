FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    zlib1g-dev \
    libonig-dev \
  && docker-php-ext-install pdo pdo_pgsql zip

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Create a non-root user to match typical host UID
RUN useradd -G www-data,root -u 1000 -d /home/dev dev || true
RUN chown -R dev:dev /var/www/html
USER dev

# Copy DB wait script (image will have it at /usr/local/bin)
COPY --chown=dev:dev docker/wait-for-postgres.sh /usr/local/bin/wait-for-postgres.sh
RUN chmod +x /usr/local/bin/wait-for-postgres.sh || true

ENTRYPOINT ["/usr/local/bin/wait-for-postgres.sh"]
CMD ["php-fpm"]
