#!/bin/bash

source /var/www/slideshow/config.config

#If autoremoved enabled you have X or more files, move files that are Y days or older to /Backup (X / Y Definded in config).

if $autoremove; then
    for f in *;
    do
    	file_count=$(ls | wc -l)
    	if [ $file_count -gt $autoremoveamount ];
    	then
    		str=""
    		for i in {2..9};
    		do
    			str+="${f:i:1}"
    		done
    		cdate="$(date +"%Y%m%d")"
    		cdateint=$((cdate - $autoremovetime))
    		str=$((str))
    		if [ $str -le $cdateint ];
    		then
    			mv $f /backup
    
    		fi
    	fi
    done
fi

# Run feh with the specified parameters as the user
feh --auto-rotate -q -p -Z -F -R 60 -Y -D "$timedelay" /var/www/slideshow/uploads/*