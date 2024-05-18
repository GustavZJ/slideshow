cd /var/www/slideshow

oldmessage=$(git log -1)

git reset --hard

git pull https://github.com/GustavZJ/slideshow.git

message=$(git log -1)
readme=$(cat README.md)
touch message.txt

echo $message >> message.txt

echo $readme >> message.txt

isnew=[ $oldmessage != $message ]
isnew=true
if [ isnew ]; then
curl --url 'smtps://smtp.gmail.com:465' --ssl-reqd \
 --mail-from 'updatereminder18@gmail.com' \
 --mail-rcpt 'gust3371@gmail.com' \
 --user 'updatereminder18@gmail.com:jjod zvvi lyoh lnbq' \
 -T <(echo -e 'From: updatereminder18@gmail.com\nTo: gust3371@gmail.com\nSubject: Super Crytikal Iformazion!!\n\n The newest commit message is '{$message}'') \
 --upload-file 'message.txt'
fi

chmod 744 admin/changeconfig.sh
chown www-data:www-data admin/changeconfig.sh
systemctl restart apache2
rm message.txt