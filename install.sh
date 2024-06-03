#!/bin/bash

cd /var/www/slideshow/
sudo git config --global --add safe.directory /var/www/slideshow
bash update.sh

# Install dependencies
apt-get update
apt-get install php mariadb-server php-mysql libapache2-mod-php php-curl feh libheif1 libheif-examples imagemagick php-imagick expect -y

mkdir "/home/$(sudo -u $SUDO_USER echo $SUDO_USER)/.config/autostart/"
mkdir uploads
mkdir backup
mkdir temp

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


htpasswd -b -c /etc/apache2/.htpasswd admin $adminpasswd
htpasswd -b -c /etc/apache2/.htpasswdadmin admin $adminpasswd



echo Enter the password for the upload user. This will be needed when uploading pictures. 
htpasswd /etc/apache2/.htpasswd uploader

# Define MySQL root password and other secure installation options
MYSQL_ROOT_PASSWORD=$adminpasswd
CHANGE_ROOT_PASSWORD="n"
REMOVE_ANONYMOUS_USERS="y"
DISALLOW_ROOT_LOGIN_REMOTELY="y"
REMOVE_TEST_DATABASE="y"
RELOAD_PRIVILEGE_TABLES="y"

# Create the Expect script for mysql_secure_installation
SECURE_MYSQL=$(expect -c "
spawn sudo mysql_secure_installation
expect \"Enter password for user root:\"
send \"$MYSQL_ROOT_PASSWORD\r\"
expect \"Change the password for root ? ((Press y|Y for Yes, any other key for No) :\"
send \"n\r\"
expect \"Remove anonymous users? (Press y|Y for Yes, any other key for No) :\"
send \"y\r\"
expect \"Disallow root login remotely? (Press y|Y for Yes, any other key for No) :\"
send \"y\r\"
expect \"Remove test database and access to it? (Press y|Y for Yes, any other key for No) :\"
send \"y\r\"
expect \"Reload privilege tables now? (Press y|Y for Yes, any other key for No) :\"
send \"y\r\"
expect eof
")
# Run the Expect script
echo "$SECURE_MYSQL"

# Restart MySQL service
sudo systemctl restart mysql

# Output success message
echo "MySQL secure installation completed successfully."

bash update.sh