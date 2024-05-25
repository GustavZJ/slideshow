#!/usr/bin/env bash

# Assign variables from the script arguments
upload_max_filesize=$1
post_max_size=$2
max_file_uploads=$3
timedelay=$4
autoremove=$5
autoremoveamount=$6
autoremovetime=$7

# Debugging: Print the variables to check their values
echo "upload_max_filesize=$upload_max_filesize"
echo "post_max_size=$post_max_size"
echo "max_file_uploads=$max_file_uploads"
echo "timedelay=$timedelay"
echo "autoremove=$autoremove"
echo "autoremoveamount=$autoremoveamount"
echo "autoremovetime=$autoremovetime"

# Update php.ini file
for key in upload_max_filesize post_max_size max_file_uploads
do
    value=${!key}
    echo "Updating php.ini: $key = $value"
    sed -i "s/^\($key\).*/\1 = ${value}/" /var/www/slideshow/php.ini
done

# Update config.config file
for key in timedelay autoremove autoremoveamount autoremovetime
do
    value=${!key}
    echo "Updating config.config: $key=$value"
    sed -i "s/^\($key\).*/\1=${value}/" /var/www/slideshow/config.config
done