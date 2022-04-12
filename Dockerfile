FROM php:8.0-fpm

RUN apt-get update

RUN apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_mysql sockets \
    && curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN chown -R www-data:www-data /var/www/html

RUN composer install