<?php
foreach ($_POST['configForm'] as $data) {
    echo("<script>console.log('PHP: " . $data . "');</script>");
}
// header('location: config.html');
// exit();