cd /var/www/slideshow

git reset --hard

git pull https://github.com/GustavZJ/slideshow.git

chmod 744 admin/changeconfig.sh
chown www-data:www-data admin/changeconfig.sh
systemctl restart apache2