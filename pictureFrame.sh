#!/bin/bash

# Remove all files in the temp directory
sudo rm -rf temp/*

# Run the update script
sudo bash update.sh

# Check if the uploads directory is empty
if [ -z "$(ls -A /var/www/slideshow/uploads)" ]; then
    bash addtest.sh
fi

# Source the configuration file if it exists
if [ -f /var/www/slideshow/config.config ]; then
    source /var/www/slideshow/config.config
else
    echo "Configuration file not found!"
    exit 1
fi

# Function to move old files to backup
move_old_files_to_backup() {
    local dir=$1
    local dest=$2
    local current_date=$(date +"%Y%m%d")
    local threshold_date=$((current_date - autoremovetime))

    for file in "$dir"/*; do
        file_count=$(ls "$dir" | wc -l)
        if [ "$file_count" -gt "$autoremoveamount" ]; then
            file_date_str=$(basename "$file" | cut -c1-8)
            if [[ "$file_date_str" =~ ^[0-9]{8}$ ]]; then
                file_date_int=$(date -d "$file_date_str" +"%Y%m%d")
                if [ "$file_date_int" -le "$threshold_date" ]; then
                    mv "$file" "$dest"
                fi
            fi
        fi
    done
}

# Function to remove old files from backup
remove_old_files_from_backup() {
    local dir=$1
    local current_date=$(date +"%Y%m%d")
    local threshold_date=$((current_date - autoremovetime - 10000))

    for file in "$dir"/*; do
        file_count=$(ls "$dir" | wc -l)
        if [ "$file_count" -gt "$autoremoveamount" ]; then
            file_date_str=$(basename "$file" | cut -c1-8)
            if [[ "$file_date_str" =~ ^[0-9]{8}$ ]]; then
                file_date_int=$(date -d "$file_date_str" +"%Y%m%d")
                if [ "$file_date_int" -le "$threshold_date" ]; then
                    rm "$file"
                fi
            fi
        fi
    done
}

# Move old files from uploads to backup if autoremoval is enabled
if [ "$autoremove" = true ]; then
    move_old_files_to_backup "/var/www/slideshow/uploads" "/var/www/slideshow/backup"
fi

# Remove old files from backup directory
remove_old_files_from_backup "/var/www/slideshow/backup"

# Run feh with the specified parameters as the user
feh --auto-rotate -q -p -Z -F -R 60 -Y -D "$timedelay" /var/www/slideshow/uploads
