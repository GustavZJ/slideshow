<?php

function convertHeic() {
    $files = scandir('/var/www/slideshow/temp');
    echo $files;
foreach($files as $file) {
    echo $file;
    // Maestroerror\HeicToJpg::convert($file)->saveAs("image1.jpg");
}
    
}

// header('Content-Type: application/json');
// echo json_encode($convertedFile);
// exit();