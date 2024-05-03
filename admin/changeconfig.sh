#!/usr/bin/env bash

upload_max_filesize=$1
post_max_size=$2
time_delay=$3

echo $upload_max_filesize $post_max_size $time_delay
for key in upload_max_filesize post_max_size max_execution_time max_input_time
do
 sed -i "s/^\($key\).*/\1 $(eval echo = \${$key})/" /var/www/slideshow/php.ini
done

for key in time_delay
do
 sed -i "s/^\($key\).*/\1 $(eval echo = \${$key})/" /var/www/slideshow/config.ini
done