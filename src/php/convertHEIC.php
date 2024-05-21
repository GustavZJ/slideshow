<?php

function convertHeic() {
        $files = scandir('/var/www/slideshow/temp');
    foreach($files as $file) {
        echo "/var/slideshow/www/temp/".$file;
        if(is_file("/var/slideshow/www/temp/".$file)) {
            echo success;
            Maestroerror\HeicToJpg::convert("/var/slideshow/www/temp/".$file)->saveAs("/var/slideshow/www/temp/".$file.".jpg");
        }
        
    }
    
}


convertHeic();
// header('Content-Type: application/json');
// echo json_encode($convertedFile);
// exit();