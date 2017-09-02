#!/bin/bash
set -e

# Configure UID
echo "- Configure UID"
groupmod -g $GID www-data
usermod -u $UID -g www-data www-data

# Configure PHP
echo "- Configure PHP"
sed -i "s/;date.timezone =.*/date.timezone = UTC/" /etc/php/7.0/fpm/php.ini
sed -i "s/;date.timezone =.*/date.timezone = UTC/" /etc/php/7.0/cli/php.ini 
sed -i -e "s/;daemonize\s*=\s*yes/daemonize = no/g" /etc/php/7.0/fpm/php-fpm.conf
sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/" /etc/php/7.0/fpm/php.ini
sed -i "s/;listen.owner = www-data/listen.owner = www-data/" /etc/php/7.0/fpm/pool.d/www.conf
sed -i "s/;listen.group = www-data/listen.group = www-data/" /etc/php/7.0/fpm/pool.d/www.conf
sed -i "s/;listen.mode = 0660/listen.mode = 0660/" /etc/php/7.0/fpm/pool.d/www.conf

# Configure Nginx
echo "- Configure Nginx"
echo "daemon off;" >> /etc/nginx/nginx.conf

# Configure Keeweb
echo "- Configure Keeweb"
cp /vendor/keeweb-v1.5.5/index.html /app/keeweb.html
sed -i "s/(no-config)/${WEBDAV_BASEURI//\//\\/}files\/keeweb\.config\.json/" /app/keeweb.html

# Configure App
echo "- Configure App"
cd /app

mkdir -p data 
mkdir -p config

if [[ ! -f /app/files/files/keeweb.config.json ]]; then
    cp /app/default-files/* /app/files/files/
fi

chmod a+rwx /app/data
chmod a+rwx /app/files

cp /template/nginx.conf.template /nginx.conf
sed -i "s/%%WEBDAV_BASEURI%%/${WEBDAV_BASEURI//\//\\/}/" /nginx.conf
mv /nginx.conf /etc/nginx/sites-available/default

cp /template/params.php.template /params.php
chmod a+rx /params.php

sed -i "s/%%WEBDAV_USERNAME%%/${WEBDAV_USERNAME//\//\\/}/" /params.php
sed -i "s/%%WEBDAV_PASSWORD%%/${WEBDAV_PASSWORD//\//\\/}/" /params.php
sed -i "s/%%WEBDAV_BASEURI%%/${WEBDAV_BASEURI//\//\\/}/" /params.php
sed -i "s/%%BRUTEFORCE_PROTECTION_MAXRETRY%%/${BRUTEFORCE_PROTECTION_MAXRETRY//\//\\/}/" /params.php
mv /params.php /app/config/params.php

chown -R www-data:www-data /app
chown -R www-data:www-data /var/www

echo "- Install vendors"

if [[ $DEV_COMPOSER ]]; then
    gosu www-data composer update --prefer-source
else
    gosu www-data composer update
fi

touch /initialized
