FROM xpert13/workspace:v.1.8.4

ARG USER_ID
ARG GROUP_ID

USER root

RUN if [ ${USER_ID} -ne 0 ] && [ ${GROUP_ID} -ne 0 ]; then \
    userdel -f laradock &&\
    if getent group laradock ; then groupdel laradock; fi &&\
    groupadd -g ${GROUP_ID} laradock &&\
    useradd -l -u ${USER_ID} -g laradock laradock &&\
    adduser laradock sudo &&\
    install -d -m 0755 -o laradock -g laradock /home/laradock &&\
    chown --changes --silent --no-dereference --recursive \
          --from=$LARADOCK_PUID:$LARADOCK_PGID ${USER_ID}:${GROUP_ID} \
        /home/laradock \
        /usr/local/sbin/php-fpm \
        /usr/local/include/php/ext/session \
;fi

#####################################
# Cron
#####################################

USER laradock
RUN (crontab -l ; echo "* * * * * /usr/local/bin/php /var/www/artisan schedule:run >> /dev/null 2>&1") | crontab
USER root

#####################################
# Prod vs Dev:
#####################################

ARG APP_ENV=prod
COPY ./opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN if [ ${APP_ENV} = dev ]; then \
    # Enable XDebug for dev
    docker-php-ext-enable xdebug; \
    # Disable OPcache for dev
    rm -f /usr/local/etc/php/conf.d/opcache.ini \
else \
    # Disable XDebug for prod
    rm -f /usr/local/etc/php/conf.d/xdebug.ini \
;fi

# Install & enable php extention for package: citeproc-php
RUN docker-php-ext-install intl && \
    docker-php-ext-enable intl

USER laradock
