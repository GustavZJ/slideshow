<?php
// Get root of web
$docRoot = $_SERVER['DOCUMENT_ROOT'];

$response = array();
foreach ($_POST['files'] as $file) {
    if (rename($docRoot . '/uploads/' . $file, $docRoot . '/backup/' . $file)) {
        $response[$file] = "success";
    } else {
        $response[$file] = "error";
    }
}

header('Content-Type: application/json');
echo json_encode($response);
exit();