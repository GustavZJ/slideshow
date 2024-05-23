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

# If you have X or more files, move files that are 6 months or older to /home/pi/Backup/.

	# for f in *;
	# do
	# 	file_count=$(ls | wc -l)
	# 	if [ $file_count -gt 20 ];
	# 	then
	# 		str=""
	# 		for i in {0..7};
	# 		do
	# 			str+="${f:i:1}"
	# 		done
	# 		cdate="$(date +"%Y%m%d")"
	# 		cdateint=$((cdate - 600))
	# 		str=$((str))
	# 		if [ $str -le $cdateint ];
	# 		then
	# 			mv $f ../backup

	# 		fi
	# 	fi
	# done
cd ..

XAUTHORITY="/home/$USER/.Xauthority" DISPLAY=:0.0 feh --auto-rotate -q -p -Z -F -R 60 -Y -D "$timedelay" uploads/