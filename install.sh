#!/bin/bash

cd /var/www/slideshow
bash update.sh

apt-get update
apt-get install git -y
apt-get install apache2 -y
apt-get install feh -y
apt-get install libheif1 -y
cp /var/www/slideshow/installFiles/rc.local /etc/rc.local