#!/bin/bash

sudo bash update.sh

# Source the configuration file
source /var/www/slideshow/config.config

# If autoremoval is enabled and there are more than a specified number of files,
# move files that are older than a specified number of days to /Backup.

if $autoremove; then
    for file in *; do
        file_count=$(ls | wc -l)
        if [ $file_count -gt $autoremoveamount ]; then
            file_date_str=""
            for i in {0..7}; do
                file_date_str+="${file:i:1}"
            done
            
            current_date="$(date +"%Y%m%d")" # Example: 20240525
            threshold_date=$((current_date - $autoremovetime))
            file_date_int=$((file_date_str))
            
            if [ $file_date_int -le $threshold_date ]; then
                mv $file /backup
            fi
        fi
    done
fi

# Run feh with the specified parameters as the user
feh --auto-rotate -q -p -Z -F -R 60 -Y -D "$timedelay" /var/www/slideshow/uploads/*
