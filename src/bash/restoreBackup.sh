#!/bin/bash

for file in /var/www/slideshow/backup/*; do
    cp /var/www/slideshow/backup/$file /var/www/slideshow/uploads/$file
done;