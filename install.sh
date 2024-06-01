#!/bin/bash

cd /var/www/slideshow/
sudo git config --global --add safe.directory /var/www/slideshow
bash update.sh

# Install dependencies
apt-get update
apt-get install php libapache2-mod-php php-curl feh libheif1 libheif-examples imagemagick php-imagick -y

mkdir "/home/$(sudo -u $SUDO_USER echo $SUDO_USER)/.config/autostart/"
mkdir uploads
mkdir backup


# Create cron job for auto update
# Define the new cron job
new_cron_job="@reboot /var/etc/slideshow/update.sh &"

# Get the current crontab entries
current_cron=$(crontab -l 2>/dev/null)

# Check if the job already exists
if ! echo "$current_cron" | grep -F "$new_cron_job" > /dev/null; then
  # Add a newline if current_cron is not empty and does not end with a newline
  if [ -n "$current_cron" ] && [ "${current_cron: -1}" != $'\n' ]; then
    current_cron="$current_cron"$'\n'
  fi

  # Add an extra line break before the comment and the new job
  updated_cron="$current_cron"$'\n'"# Update slideshow"$'\n'"$new_cron_job"

  # Install the new crontab
  echo "$updated_cron" | crontab -
fi

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

bash update.sh