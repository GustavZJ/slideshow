cd /var/www/slideshow

oldmessage=$(git log -1)

git reset --hard

git pull https://github.com/GustavZJ/slideshow.git

message=$(git log -1 --pretty=%B)
readme=$(cat README.md)
touch message.html

echo "From: "Slideshow Update Reminder" <updatereminder18@gmail.com>" >> message.html
echo "To: "Henrik Pedersen" <hoeckjohanged@gmail.com>" >> message.html
echo "Subject: The newest release of slideshow has been installed." >> message.html
echo "" >> message.html
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
#if [ isnew ]; then
#curl --ssl-reqd \
#  --url 'smtps://smtp.gmail.com:465' \
#  --user 'updatereminder18@gmail.com:jjod zvvi lyoh lnbq' \
#  --mail-from 'updatereminder18@gmail.com' \
#  --mail-rcpt 'hoeckjohanged@gmail.com' \
#  --upload-file message.html
#fi

chmod 744 admin/changeconfig.sh
chown www-data:www-data admin/changeconfig.sh
systemctl restart apache2
rm message.html