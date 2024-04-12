#!/bin/bash

cd /var/www/slideshow
bash update.sh

apt-get update
apt-get install git apache2 php libapache2-mod-php feh libheif1 -y
cp /var/www/slideshow/installFiles/rc.local /etc/rc.local

mkdir tmp
mkdir uploads
mkdir backup