FROM php:7.4.1-apache

RUN apt-get update && apt-get install -y libpng-dev zip unzip wget zlib1g-dev libicu-dev libzip-dev netcat sqlite3 libsqlite3-dev
     #&& git clone https://github.com/nodejs/node.git \
     #&& cd node \
     #&& ./configure \
     #&& make \
     #&& sudo make install \
RUN docker-php-ext-install mysqli pdo_mysql zip exif
RUN apt-get install -y \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libpng-dev libxpm-dev \
    libfreetype6-dev
RUN docker-php-ext-install gd
RUN docker-php-ext-install exif
RUN docker-php-ext-configure exif \
            --enable-exif

RUN docker-php-ext-install opcache  && \
     docker-php-ext-enable opcache

ENV PHPREDIS_VERSION 3.0.0
ENV NODE_VERSION 12.6.0

#install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

#set our application folder as an environment variable
ENV APP_HOME /var/www/html

#change uid and gid of apache to docker user uid/gid
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

#change the web_root to laravel /var/www/html/public folder
#RUN sed -i -e "s/html/html\/public/g" /etc/apache2/sites-enabled/000-default.conf
COPY .docker/apache/default.conf /etc/apache2/sites-enabled/000-default.conf
COPY .docker/laravel.ini /usr/local/etc/php/
# enable apache module rewrite
#RUN a2enmod rewrite
#RUN a2enmod headers
RUN if command -v a2enmod >/dev/null 2>&1; then \
        a2enmod rewrite headers \
    ;fi

#copy source files and run composer
ADD ./srv /var/www/html
# install all PHP dependencies
#RUN php -r "file_exists('.env') || copy('.env.example', '.env');"
#RUN composer install --no-interaction
#RUN echo "Node: " && node -v
#RUN echo "NPM: " && npm -v
#RUN npm install && npm run prod
#change ownership of our applications
RUN php artisan migrate --seed
RUN chown -R www-data:www-data $APP_HOME

#update apache port at runtime for Heroku
ENTRYPOINT []
CMD php artisan serve --host=0.0.0.0