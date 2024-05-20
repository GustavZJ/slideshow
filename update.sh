cd /var/www/slideshow

oldmessage=$(git log -1)

git reset --hard

git pull https://github.com/GustavZJ/slideshow.git

message=$(git log -1 --pretty=%B)
readme=$(cat README.md)
touch message.html

echo "<!DOCTYPE html>" >> message.html
echo "<html>" >> message.html
echo "<body>" >> message.html
echo $message >> message.html
echo $readme >> message.html
echo "</html>" >> message.html
echo "</body>" >> message.html

#html=$(cat message.html)

#isnew=[ $oldmessage != $message ]
isnew=true

python email_sender.py hoeckjohanged@gmail.com "Update Reminder"
chmod 744 admin/changeconfig.sh
chown www-data:www-data admin/changeconfig.sh
systemctl restart apache2
rm message.html