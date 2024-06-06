#!/bin/bash

cd /var/www/slideshow/
sudo git config --global --add safe.directory /var/www/slideshow
bash update.sh

# Install dependencies
apt-get update
apt-get install php python3-pyqrcode libapache2-mod-php php-curl feh libheif1 libheif-examples imagemagick php-imagick -y

mkdir "/home/$(sudo -u $SUDO_USER echo $SUDO_USER)/.config/autostart/"
mkdir uploads
mkdir backup
mkdir temp

hostname=$(hostname)

python3 src/py/qrGen.py "http://$hostname.local"
      

cp installFiles/defaultphp.ini /var/www/slideshow/php.ini
cp installFiles/defaultconfig.config /var/www/slideshow/config.config
cp installFiles/slideshow.conf /etc/apache2/sites-available/slideshow.conf
cp installFiles/pictureframe.desktop /home/"$(sudo -u $SUDO_USER echo $SUDO_USER)"/.config/autostart/pictureframe.desktop

a2enmod headers
a2enmod rewrite

a2dissite 000-default.conf
a2dissite slideshow.conf
a2ensite slideshow.conf

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

adminpasswd1="passwd1"
adminpasswd2="passwd2"
adminpasswd=""

while [ "$adminpasswd1" != "$adminpasswd2" ]; do
    echo "Enter the password for the admin user. This will be needed when changing settings and removing pictures. You will not be able to see what you type." 
    stty -echo
    read adminpasswd1
    stty echo

    echo "Enter the same password for the admin user again." 
    stty -echo
    read adminpasswd2
    stty echo

    if [ "$adminpasswd1" != "$adminpasswd2" ]; then
        echo "There was an error. The process will restart."
        echo
    fi
done

echo "Admin password configured."
adminpasswd=$adminpasswd1


htpasswd -b -B -c /etc/apache2/.htpasswd admin $adminpasswd
htpasswd -b -B -c /etc/apache2/.htpasswdadmin admin $adminpasswd

uploaderpasswd1="passwd1"
uploaderpasswd2="passwd2"
uploaderpasswd=""

while [[ "$uploaderpasswd1" != "$uploaderpasswd2" || "$uploaderpasswd1" == "$adminpasswd" ]]; do
    echo "Enter the password for the uploader user. This will be needed when uploading pictures. You will not be able to see what you type." 
    stty -echo
    read uploaderpasswd1
    stty echo

    echo "Enter the same password for the uploader user again." 
    stty -echo
    read uploaderpasswd2
    stty echo

    if [ "$uploaderpasswd1" != "$uploaderpasswd2" ]; then
        echo
        echo "There was an error. The process will restart."
        echo
        echo
    elif [ "$uploaderpasswd1" == "$adminpasswd" ]; then
        echo
        echo "You are not allowed to use the same password for both uploader and admin. The process will restart."
        echo
        echo
    fi
done

echo "Uploader password configured."
uploaderpasswd=$uploaderpasswd1

bash update.sh