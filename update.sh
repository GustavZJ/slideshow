cd /var/www/slideshow

oldmessage=$(git log -1 --pretty=%B)
sudo git config --global --add safe.directory /var/www/slideshow

git reset --hard

git pull --rebase https://github.com/GustavZJ/slideshow.git email-support

message=$(git log -1 --pretty=%B)
subject="Slideshow just updated! The newest commit is \"$message\"" 
readme=$(cat README.md)
touch message.html

echo "<!DOCTYPE html>" >> message.html
echo "<html>" >> message.html
echo "<body>" >> message.html
echo $subject >> message.html
echo $readme >> message.html
echo "<a href=\"$(hostname).local\">Click here to unsubscribe</a>" >> message.html
echo "</html>" >> message.html
echo "</body>" >> message.html

cat message.html
python3 email_sender.py "$subject."


if [  -f nothing.here -a "$oldmessage" != "$message" ]; then
    
fi

chmod -R 777 /var/www/slideshow/
chown -R www-data:www-data /var/www/slideshow/
sudo git config --global --add safe.directory /var/www/slideshow
systemctl restart apache2
rm message.html