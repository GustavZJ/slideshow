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

if ! test -f etc/apache2/.htpasswd; then
    
    echo Enter the password for the upload user. This will be needed when uploading pictures. \n
    read uploadpasswd
    echo Enter the password for the admin user. This will be needed when changing settings and removing pictures. \n
    read adminpasswd;
    
    echo $uploaderpasswd
    echo $uploaderpasswd


    htpasswd -b -c /etc/apache2/.htpasswd uploader $uploaderpasswd
    htpasswd -b /etc/apache2/.htpasswd admin $adminpasswd
    htpasswd -b -c /etc/apache2/.htpasswdadmin admin $adminpasswd
fi
bash update.sh