#!/usr/bin/env bash

upload_max_filesize=$1
post_max_size=$2
timedelay=$3
max_file_uploads=$4
autoremove=$5
autoremoveamount=$6
autoremovetime=$7

for key in upload_max_filesize post_max_size max_file_uploads
do
 sed -i "s/^\($key\).*/\1 $(eval echo = \${$key})/" /var/www/slideshow/php.ini
done

for key in timedelay autoremove autoremoveamount autoremovetime
do
 sed -i "s/^\($key\).*/\1=$(eval echo \${$key})/" /var/www/slideshow/config.config
done