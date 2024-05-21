<?php

function convertHeic() {
        $files = scandir('/var/www/slideshow/temp/');
    foreach($files as $file) {
        $file_name = "/var/www/slideshow/temp/".$file;
        echo $file_name."<br>" ;
        if(is_file($file_name)) {
            echo "success";
            Maestroerror\HeicToJpg::convert("/var/www/slideshow/temp/".$file)->saveAs("/var/www/slideshow/temp/".$file.".jpg");
        }
        
    }
    
}


convertHeic();
// header('Content-Type: application/json');
// echo json_encode($convertedFile);
// exit();