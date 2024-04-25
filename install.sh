#!/bin/bash
cd /var/www/slideshow/
bash update.sh

apt-get update
apt-get install php libapache2-mod-php feh libheif1 -y
cp installFiles/rc.local /etc/rc.local
cp installFiles/slideshow.conf /etc/apache2/sites-available/slideshow.conf
a2dissite 000-default.conf
a2dissite slideshow.conf
a2ensite slideshow.conf
mkdir uploads
mkdir backup
chmod 777 uploads/
bash update.sh