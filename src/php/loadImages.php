<?php
// Get root of web
$docRoot = $_SERVER['DOCUMENT_ROOT'];

$imagePath = $docRoot . '/uploads';
$images = scandir($imagePath);
$files = array();

foreach($images as $image) {
    $fullImage = $imagePath . $image;
    if (is_file($fullImage)) {
        array_push($files, $image.' - '.$fullImage);
        // URL encode the file path for displaying in the HTML
        $encodedImage = str_replace('?', '%3F', $image);
        $fullImage = $imagePath . $encodedImage;
        // array_push($files, htmlspecialchars($fullImage));
    }
}

header("Content-Type: application/json");
echo json_encode($files);