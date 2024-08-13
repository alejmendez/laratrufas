# sudo docker compose down ; sudo docker compose up -d
# sudo docker exec laratrufa_app php artisan app:sync-permissions

docker compose down
git pull

npm install -g npm@latest
npm i
npm run build

docker compose up -d
docker exec laratrufa_app composer install --optimize-autoloader --no-dev
docker exec laratrufa_app php artisan optimize
