#!/bin/bash


# Find the user currently logged into the graphical session
USER=$(loginctl list-sessions | awk '/seat0/ {print $3}')

# If no user is found, exit
if [ -z "$USER" ]; then
  echo "No user found on seat0."
  exit 1
fi

# Set the DISPLAY and XAUTHORITY environment variables
DISPLAY=:0
XAUTHORITY="/home/$USER/.Xauthority"

export DISPLAY
export XAUTHORITY

cd /var/www/slideshow/uploads

source /var/www/slideshow/config.config


cd ..

sudo -u $USER DISPLAY=$DISPLAY XAUTHORITY=$XAUTHORITY feh --auto-rotate -q -p -Z -F -R 60 -Y -D "$timedelay" uploads/
