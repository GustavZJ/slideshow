<?php

require 'vendor/autoload.php'; // Make sure to include the Composer autoloader

use Maestroerror\HeicToJpg;


function convertHeic() {
        $files = scandir('/var/www/slideshow/temp/');
    foreach($files as $file) {
        $file_name = "/var/www/slideshow/temp/".$file;
        // echo $file_name."<br>" ;
        if(is_file($file_name)) {
            Maestroerror\HeicToJpg::convert("/var/www/slideshow/temp/".$file, "arm64", true)->saveAs("/var/www/slideshow/temp/".$file.".jpg");
            echo $file_name." success";
        }
        
    }
    
}


convertHeic();
// header('Content-Type: application/json');
// echo json_encode($convertedFile);
// exit();