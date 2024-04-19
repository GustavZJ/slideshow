#!/bin/bash

bash update.sh

apt-get update
apt-get install php8.2 libapache2-mod-php feh libheif1 -y
cp installFiles/rc.local /etc/rc.local
cp installFiles/php.ini /etc/php/8.2/apache2/php.ini
cp installFiles/slideshow.conf /etc/apache2/sites-available/
a2dissite 000-default.conf
a2dissite slideshow.conf
a2ensite slideshow.conf
bash update.sh

mkdir uploads
mkdir backup