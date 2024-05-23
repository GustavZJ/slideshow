#!/bin/bash

# Don't run this as root!
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
#
#xhost si:localuser:root
#XAUTHORITY=~/.Xauthority DISPLAY=:0.0 feh exif=1 --auto-rotate -q -p -Z -F -R 60 -Y -D $timedelay uploads/
#xhost -si:localuser:root

