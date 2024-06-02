cd /var/www/slideshow

is_connected() {
    wget -q --spider http://google.com
    return $?  # Return the exit status of wget (0 if connected, non-zero if not connected)
}

# Wait until the network is available
while ! is_connected; do
    sleep 10
done

oldmessage=$(git log -1 --pretty=%B)
sudo git config --global --add safe.directory /var/www/slideshow

git reset --hard

git pull origin main

message=$(git log -1 --pretty=%B)
subject="Slideshow just updated! The newest commit is \"$message\"" 
readme=$(cat README.md)
touch message.html

echo "<!DOCTYPE html>" >> message.html
echo "<html>" >> message.html
echo "<body>" >> message.html
echo $subject >> message.html
echo $readme >> message.html
echo "<br> <a href=\"$(hostname).local/captcha/index.html\">Click here to unsubscribe</a>" >> message.html
echo "</html>" >> message.html
echo "</body>" >> message.html




if [  -f nothing.here -a "$oldmessage" != "$message" ]; then
    python3 /var/www/slideshow/src/py/emailSender.py "$subject."
fi

chmod -R 777 /var/www/slideshow/
chown -R www-data:www-data /var/www/slideshow/
sudo git config --global --add safe.directory /var/www/slideshow
systemctl restart apache2
rm message.html