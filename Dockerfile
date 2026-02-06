FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git unzip curl gnupg libzip-dev libicu-dev \
    libpng-dev libjpeg-dev libwebp-dev \
    && docker-php-ext-install pdo pdo_mysql zip intl bcmath gd

RUN curl -sL https://deb.nodesource.com/setup_22.x | bash -
RUN apt-get install -y nodejs

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

COPY package*.json ./
COPY composer.json composer.lock ./

COPY . .

RUN npm install
RUN composer install --no-interaction --optimize-autoloader --no-dev

RUN npm run build

RUN chown -R www-data:www-data storage bootstrap/cache public/build
