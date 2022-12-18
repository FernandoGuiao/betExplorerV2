FROM php:8.1-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql sockets
RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk --update add --no-cache bash dos2unix
COPY . .

RUN composer install
RUN apk add --update npm
RUN npm install
RUN npm run build

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000

ADD crontab.txt /crontab.txt
COPY entry.sh /entry.sh
RUN chmod 755  /entry.sh
RUN /usr/bin/crontab /crontab.txt

CMD ["/entry.sh"]

#WORKDIR /usr/scheduler

## Copy files
#COPY crontab.* ./
#COPY start.sh .
#
## Fix line endings && execute permissions
#RUN dos2unix crontab.* \
#    && \
#    find . -type f -iname "*.sh" -exec chmod +x {} \;
#
## Run cron on container startup
#CMD ["./start.sh"]
