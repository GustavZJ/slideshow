<?php

function convertHeic() {
        $files = scandir('/var/www/slideshow/temp');
    foreach($files as $file) {
        if(is_file($file)) {
            echo $file.".jpg";
            Maestroerror\HeicToJpg::convert($file)->saveAs($file.".jpg");
        }
        
    }
    
}


convertHeic();
// header('Content-Type: application/json');
// echo json_encode($convertedFile);
// exit();