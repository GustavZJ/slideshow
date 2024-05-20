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

python3 email_sender.py gust3371@gmail.com $message
chmod 744 admin/changeconfig.sh
chown www-data:www-data admin/changeconfig.sh
systemctl restart apache2
rm message.html