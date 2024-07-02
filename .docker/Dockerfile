# Utiliza una imagen oficial de PHP 8.3
FROM php:8.3-fpm

# Instala las extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    nginx \
    libpq-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install zip pdo pdo_pgsql gd

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos de la aplicación
COPY . /var/www/html

# Da permisos al usuario www-data
RUN chown -R www-data:www-data /var/www/html

# Instala las dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Instala Node.js y npm (usando Node.js 18)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# Instala las dependencias de JavaScript y construye los assets
RUN npm install && npm run build

# Optimización de Laravel para producción
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Copia el archivo de configuración de Nginx
COPY .docker/nginx.conf /etc/nginx/nginx.conf

# Expone el puerto 80
EXPOSE 80

# Inicia PHP-FPM y Nginx
CMD service nginx start && php-fpm
