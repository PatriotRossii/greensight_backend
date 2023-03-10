FROM php:8-fpm

WORKDIR /greensight/

RUN apt-get update && apt-get install -y \
	git

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install

RUN mkdir logs && chown -R www-data:www-data ./logs/

CMD bash -c "cp -r vendor /var/www/html/ && php-fpm"