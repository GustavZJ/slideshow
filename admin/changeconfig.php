<?php
foreach ($_POST['configForm'] as $element) {
    echo("<script>console.log('PHP: " . $data . "');</script>");
}
// header('location: config.html');
// exit();