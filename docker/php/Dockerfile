FROM php:8.0-fpm-alpine as basic

ARG UID
ARG GID
ENV UID=${UID}
ENV GID=${GID}

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN apk add --no-cache \
        shadow \
        unzip

COPY docker/php/config/php_prod.ini /usr/local/etc/php/php.ini

RUN install-php-extensions \
	   @composer \
	   amqp \
	   apcu \
	   bcmath \
	   intl \
	   opcache \
	   pdo_mysql \
	   sockets \
	   uuid \
	   yaml \
	   zip

ENV PATH /usr/src/bin:/usr/src/vendor/bin:$PATH

WORKDIR /usr/src



FROM basic as development
RUN apk add --no-cache \
    git
RUN install-php-extensions \
        xdebug-^3.0
RUN groupmod -g ${GID} www-data \
    && usermod -u ${UID} www-data \
    && chown -R www-data:www-data /usr/src
COPY docker/php/config/php_dev.ini /usr/local/etc/php/php.ini



FROM development as test
ENV APP_ENV=prod
COPY ./ /usr/src
RUN composer install -n --no-cache \
    && composer clear-cache -n



FROM basic as result
ENV APP_ENV=prod
COPY ./ /usr/src
RUN composer install -n --no-dev --no-cache --optimize-autoloader \
    && composer clear-cache -n \
    && rm -rf \
        docker \
        tests \
        .env.test \
        grumphp.yml \
        phpcs.xml.dist \
        phpstan.neon \
        phpunit.xml.dist



FROM basic as production
COPY --from=result /usr/src ./
RUN chown -R www-data:www-data /usr/src
USER www-data
