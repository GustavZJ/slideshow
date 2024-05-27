#!/usr/bin/env bash

# Assign variables from the script arguments
upload_max_filesize=$1
post_max_size=$2
max_file_uploads=$3
timedelay=$4
autoremove=$5
autoremoveamount=$6
autoremovetime=$7
autoremovetimepost=$8
autoremovetimeoption=$9


if [ -z ${1+x} -a  -z ${2+x} -a  -z ${3+x} -a  -z ${4+x} -a  -z ${5+x} -a  -z ${6+x} -a  -z ${7+x} ]; then
    echo "All are set"
else
    echo "Not all are set"
fi
# Update php.ini file
for key in upload_max_filesize post_max_size max_file_uploads
do
    value=${!key}
    sed -i "s/^\($key\).*/\1 = ${value}/" /var/www/slideshow/php.ini
done

# Update config.config file
for key in timedelay autoremove autoremoveamount autoremovetime autoremovetimepost autoremovetimeoption
do
    value=${!key}
    sed -i "s/^\($key\)\b.*/\1=$value/" /var/www/slideshow/config.config
done