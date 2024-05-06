#!/bin/bash

# Don't run this as root!
cd /var/www/slideshow/uploads

source /var/www/slideshow/config.config


#Iterate over all files of file type .HEIC and convert to jpeg. This is because HEIC is a shitty file format that iPhones use. 
for f in ./*.HEIC;
do
	heif-convert "$f" "$f.jpeg";
	rm $f 
done



#Remove all video files.
for f in ./*.MOV;
do
	rm $f 
done


# #Rename all files to to ?+{current date Year Month Day}+{original file name} if this hasn't already been done already.
# for f in *;
# do
# 	first_char="$(printf '%c' "$f")"
# 	if [ $first_char != "?" ];
# 	then
		
# 		new="?"+"$(date +"%Y%m%d")"+"$f"
# 		mv "$f" "$new"
# 	fi
# done
#If you have 20 or more files, move files that are 6 months or older to /home/pi/Backup/.
# for f in *;
# do
# 	file_count=$(ls | wc -l)
# 	if [ $file_count -gt 20 ];
# 	then
# 		str=""
# 		for i in {2..9};
# 		do
# 			str+="${f:i:1}"
# 		done
# 		cdate="$(date +"%Y%m%d")"
# 		cdateint=$((cdate - 600))
# 		str=$((str))
# 		if [ $str -le $cdateint ];
# 		then
# 			mv $f /backup
		
# 		fi
# 	fi
# done
cd ..
#
#xhost si:localuser:root
#XAUTHORITY=~/.Xauthority DISPLAY=:0.0 feh exif=1 --auto-rotate -q -p -Z -F -R 60 -Y -D $timedelay uploads/
#xhost -si:localuser:root

