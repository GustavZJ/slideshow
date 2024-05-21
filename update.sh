cd /var/www/slideshow

oldmessage=$(git log -1 --pretty=%B)

git reset --hard

git pull https://github.com/GustavZJ/slideshow.git

message=$(git log -1 --pretty=%B)
subject="Slideshow just updated! The newest commit is \"$message\"" 
readme=$(cat README.md)
touch message.html

echo "<!DOCTYPE html>" >> message.html
echo "<html>" >> message.html
echo "<body>" >> message.html
echo $subject >> message.html
echo $readme >> message.html
echo "</html>" >> message.html
echo "</body>" >> message.html
if [ -f nothing.here ] -a [ [ "$oldmessage" != "$message" ] ]; then
    python3 email_sender.py "$subject."
fi
chmod 744 admin/changeconfig.sh
chown www-data:www-data admin/changeconfig.sh
systemctl restart apache2
rm message.html