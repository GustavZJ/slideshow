#!/bin/bash

# Find the user currently logged into the graphical session
USER=$(loginctl list-sessions | awk '/seat0/ {print $3}')

# If no user is found, exit
if [ -z "$USER" ]; then
  echo "No user found on seat0."
  exit 1
fi

# Set the DISPLAY and XAUTHORITY environment variables
export DISPLAY=:0
export XAUTHORITY="/home/$USER/.Xauthority"

cd /var/www/slideshow/uploads || exit

source /var/www/slideshow/config.config

cd ..

# Run feh with the specified parameters as the user
sudo -u $USER env DISPLAY="$DISPLAY" XAUTHORITY="$XAUTHORITY" feh --auto-rotate -q -p -Z -F -R 60 -Y -D "$timedelay" /var/www/slideshow/uploads/
