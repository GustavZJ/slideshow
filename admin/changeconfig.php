<?php
echo("<script>console.log('PHP: " . json_encode($_POST) . "');</script>");


if(!$_POST['timedelay'] or !$_POST['upload_max_filesize'] or !$_POST['maxamount']) 

$timedelay = $_POST['timedelay'];
$upload_max_filesize = $_POST["upload_max_filesize"];
$maxamount = $_POST["maxamount"];

$post_max_size = strval(intval($upload_max_filesize)*intval($maxamount))."M";
echo get_current_user();
 $dump = shell_exec('./changeconfig.sh '. $upload_max_filesize."M ". $post_max_size." ". $timedelay);
header('location: config.html');
exit();