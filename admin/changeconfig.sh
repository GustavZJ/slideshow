#!/usr/bin/env bash

upload_max_filesize=$1
post_max_size=$2
timedelay=$3


for key in upload_max_filesize post_max_size max_execution_time max_input_time
do
 sed -i "s/^\($key\).*/\1 $(eval echo = \${$key})/" /var/www/slideshow/php.ini
done

for key in timedelay
do
 echo $key
 sed -i "s/^\($key\).*/\1=$(eval echo \${$key})/" /var/www/slideshow/config.config
done