<?php
echo("<script>console.log('PHP: " . json_encode($_POST) . "');</script>");


$timedelay = $_POST['timedelay'];
$upload_max_filesize = $_POST["upload_max_filesize"];
$maxamount = $_POST["maxamount"];

$post_max_size = strval(intval($upload_max_filesize)*intval($maxamount))."M";

 echo("shell_exec("'./changeconfig.sh '. $upload_max_filesize."M ". $post_max_size." ". $timedelay")");
// header('location: config.html');
// exit();