sudo systemctl stop nginx ; sudo systemctl stop php8.3-fpm ; sudo systemctl stop octane

git pull
composer install --optimize-autoloader --no-dev
npm run build
php artisan optimize

sudo systemctl start octane ; sudo systemctl start php8.3-fpm ; sudo systemctl start nginx
