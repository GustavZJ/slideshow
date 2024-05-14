<?php
$response = array();
foreach ($_POST['files'] as $file) {
    if (unlink('../uploads/'.$file)) {
        $response[$file] = "success";
    } else {
        $response[$file] = "error";
    }
}

header('Content-Type: application/json');
echo json_encode($response);
exit();