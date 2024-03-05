sudo apt update
sudo apt-get install software-properties-common -y

# install git
sudo apt install git -y

# install curl and node version manager
sudo apt install curl -y
curl https://raw.githubusercontent.com/creationix/nvm/master/install.sh | bash
source ~/.bashrc
nvm install node

# install php and extensions
sudo add-apt-repository ppa:ondrej/php -y
sudo apt-get install php8.3 php8.3-cli php8.3-{common,mbstring,gettext,zip,fpm,curl,gd,sqlite3,xml,redis,bcmath,imagick,bz2,intl,pdo,pdo-pgsql,fpm} -y

# install composer
curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
HASH=`curl -sS https://composer.github.io/installer.sig`
echo $HASH
php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer

# install nginx
sudo apt install nginx -y

# install nginx
sudo apt install postgresql -y

# config nginx
sudo nano /etc/nginx/sites-available/default
server {
    listen 80;
    listen [::]:80;
    # server_name 18.224.22.139;
    root /home/ubuntu/www/trufas/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}

sudo systemctl restart php8.3-fpm
sudo systemctl restart nginx

sudo adduser www-data ubuntu

mkdir /home/ubuntu/www
cd /home/ubuntu/www
git clone https://github.com/alejmendez/laratrufas.git trufas
cd /home/ubuntu/www/trufas
sudo chmod 0777 -R /home/ubuntu/www/trufas
#sudo chown www-data:www-data -R /home/ubuntu/www/trufas
sudo chown www-data:www-data -R /home/ubuntu/www/trufas

cd /home/ubuntu/www/trufas
npm install -g npm@10.5.0
npm install
composer install
npm run build
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate --seed --force
composer install --optimize-autoloader --no-dev
chmod -R ugo+rw storage/logs ; mkdir -p storage/framework/{sessions,views,cache} ; chmod -R ugo+rw storage/framework
php artisan config:cache ; php artisan event:cache ; php artisan route:cache ; php artisan view:cache

sudo nginx -t
sudo service nginx restart

alias update_app="git pull ; npm run build ; php artisan config:cache ; php artisan event:cache ; php artisan route:cache ; php artisan view:cache"
