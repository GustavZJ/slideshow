<?php
// Get root of web
$docRoot = $_SERVER['DOCUMENT_ROOT'];

$imagePath = $docRoot . '/uploads';
$images = scandir($imagePath);
$files = array();

foreach($images as $image) {
    $fullImage = $imagePath .'/'. $image;
    if (is_file($fullImage)) {
        // URL encode the file path for displaying in the HTML
        $encodedImage = htmlspecialchars($image);
        array_push($files, $encodedImage);
    }
}

header("Content-Type: application/json");
echo json_encode($files);