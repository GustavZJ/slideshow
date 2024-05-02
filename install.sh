#!/bin/bash
cd /var/www/slideshow/
bash update.sh

apt-get update
apt-get install php libapache2-mod-php php-dom feh libheif1 -y
cp installFiles/rc.local /etc/rc.local
cp installFiles/slideshow.conf /etc/apache2/sites-available/slideshow.conf
a2dissite 000-default.conf
a2dissite slideshow.conf
a2ensite slideshow.conf
mkdir uploads
mkdir backup
chmod 777 uploads/

rm /etc/apache2/.htpasswd
rm /etc/apache2/.htpasswdadmin

touch /etc/apache2/.htpasswd
touch /etc/apache2/.htpasswdadmin


echo Enter the password for the admin user. This will be needed when changing settings and removing pictures. \n
read adminpasswd;

htpasswd -b -c /etc/apache2/.htpasswd admin $adminpasswd
htpasswd -b -c /etc/apache2/.htpasswdadmin admin $adminpasswd

echo Enter the password for the upload user. This will be needed when uploading pictures. \n
htpasswd /etc/apache2/.htpasswd uploader


bash update.sh