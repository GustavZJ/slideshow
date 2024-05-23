#!/bin/bash
declare -A values
for key in upload_max_filesize post_max_size max_execution_time max_input_time max_file_uploads
do
 value=$(grep "^$key" /var/www/slideshow/php.ini | awk '{print $3}')
declare "values_$key=$value"

done
echo "$values"