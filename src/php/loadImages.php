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
        $encodedImage = rawurlencode($image);
        $fullImage = '/uploads/' . $encodedImage;
        array_push($files, $fullImage);
    }
}

header("Content-Type: application/json");
echo json_encode($files);