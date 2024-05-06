<?php
echo("<script>console.log('PHP: " . json_encode($_POST) . "');</script>");

$timedelay = $_POST["time_delay"];
$maxfilesize = $_POST["maxfilesize"];
$maxamount = $_POST["maxamount"];

echo $timedelay $maxfilesize $maxamount

// header('location: config.html');
// exit();