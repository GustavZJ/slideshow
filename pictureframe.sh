#!/bin/bash

source /var/www/slideshow/config.config

cd ..

# Run feh with the specified parameters as the user
feh --auto-rotate -q -p -Z -F -R 60 -Y -D "$timedelay" /var/www/slideshow/uploads/*