<?php

function convertHeic() {
        $files = scandir('/var/www/slideshow/temp');
    foreach($files as $file) {
        Maestroerror\HeicToJpg::convert($file)->saveAs("$file.jpg");
    }
    
}


convertHeic();
// header('Content-Type: application/json');
// echo json_encode($convertedFile);
// exit();