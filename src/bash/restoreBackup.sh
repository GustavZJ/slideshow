#!/bin/bash

for file in /var/www/slideshow/backup/*; do
    cp "$file" /var/www/slideshow/uploads/
    
done;