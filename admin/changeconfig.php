<?php
echo("<script>console.log('PHP: " . json_encode($_POST) . "');</script>");


$timedelay = $_POST['timedelay'];
$maxsize   = $_POST["maxsize"];
$maxamount = $_POST["maxamount"];



$post_max_size = strval(intval($maxsize)*intval($maxamount))."M";
echo get_current_user();
$dump = shell_exec("./changeconfig.sh ". $maxsize."M ". $post_max_size." ". $timedelay);
// echo $dump;
header('location: config.html');
exit();