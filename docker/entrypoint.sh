#!/bin/bash

# Install dependencies if vendor folder doesn't exist
if [ ! -d "vendor" ]; then
    composer install --no-interaction --optimize-autoloader
fi

# Install npm dependencies if node_modules folder doesn't exist
if [ ! -d "node_modules" ]; then
    npm install
fi

# Build assets if build folder doesn't exist
if [ ! -d "public/build" ]; then
    npm run build
fi

# Generate key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate
fi

# Run migrations (only in app role)
if [ "$1" = "app" ]; then
    php artisan migrate --force
fi

# Role-based startup
case "$1" in
    app)
        exec php-fpm
        ;;
    worker)
        # Background worker for processing events (Pusher broadcasting)
        exec php artisan queue:work --verbose --tries=3 --timeout=90
        ;;
    *)
        exec "$@"
        ;;
esac
