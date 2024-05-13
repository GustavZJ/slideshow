<?php
echo("<script>console.log('PHP: " . json_encode($_POST) . "');</script>");


$timedelay = $_POST['timedelay'];
$maxfilesize   = $_POST["maxfilesize"];
$maxamount = $_POST["maxamount"];



$post_max_size = strval(intval($maxfilesize)*intval($maxamount))."M";
echo get_current_user();
shell_exec("../clear.sh");
// $dump = shell_exec("./changeconfig.sh ". $maxfilesize."M ". $post_max_size." ". $timedelay);
// echo $dump;
// header('location: config.html');
// exit();