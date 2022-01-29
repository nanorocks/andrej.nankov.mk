set -e

echo "Deploying application ..."

set -e

echo "Deploying application ..."

# Enter maintenance mode
(php artisan down --message 'The app is being (quickly!) updated. Please try again in a minute.') || true
    # Update codebase
    git pull origin master
    # Composer update and install again for new packages
    composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
# Exit maintenance mode
php artisan up

echo "Application deployed!"
