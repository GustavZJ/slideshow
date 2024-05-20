#!/bin/bash
cd /var/www/slideshow/
bash update.sh

apt-get update
apt-get install php libapache2-mod-php feh libheif1 libheif-examples   -y


# , python3-email, python3-smtplib, python3-ssl

python3 -m venv .venv
source .venv/bin/activate
pip install email, ssl, smtplib
cp installFiles/rc.local /etc/rc.local
cp installFiles/defaultphp.ini /var/www/slideshow/php.ini
cp installFiles/defaultconfig.config /var/www/slideshow/config.config
cp installFiles/slideshow.conf /etc/apache2/sites-available/slideshow.conf

a2dissite 000-default.conf
a2dissite slideshow.conf
a2ensite slideshow.conf

mkdir uploads
mkdir backup

chmod 777 uploads/
chmod +x admin/changeconfig.sh

rm /etc/apache2/.htpasswd
rm /etc/apache2/.htpasswdadmin

touch /etc/apache2/.htpasswd
touch /etc/apache2/.htpasswdadmin

echo 
echo 
echo 
echo 
echo 
echo 
echo 

echo Enter the password for the admin user. This will be needed when changing settings and removing pictures. You will not be able to see what you type. 
stty -echo
read adminpasswd;
stty echo

htpasswd -b -c /etc/apache2/.htpasswd admin $adminpasswd
htpasswd -b -c /etc/apache2/.htpasswdadmin admin $adminpasswd

echo Enter the password for the upload user. This will be needed when uploading pictures. 
htpasswd /etc/apache2/.htpasswd uploader

bash update.sh