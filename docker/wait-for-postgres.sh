#!/usr/bin/env bash

# wait-for-postgres.sh
# Wait until Postgres is available, then exec the container CMD

set -e

: ${DB_HOST:=db}
: ${DB_PORT:=5432}
: ${RETRIES:=20}
: ${SLEEP:=2}

i=0
until pg_isready -h "$DB_HOST" -p "$DB_PORT" >/dev/null 2>&1; do
  i=$((i+1))
  if [ "$i" -ge "$RETRIES" ]; then
    echo "Postgres did not become available in time"
    break
  fi
  echo "Waiting for Postgres... ($i/$RETRIES)"
  sleep "$SLEEP"
done

# Exec the main command
exec "$@"
