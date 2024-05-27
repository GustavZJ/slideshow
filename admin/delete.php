<?php
$response = array();
foreach ($_POST['files'] as $file) {
    if (rename('../uploads/' . $file, '../backup/' . $file)) {
        $response[$file] = "success";
    } else {
        $response[$file] = "error";
    }
}

header('Content-Type: application/json');
echo json_encode($response);
exit();