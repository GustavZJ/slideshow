<?php
echo ("<script>console.log('PHP: " . json_encode($_POST) . "');</script>");


$timedelay = preg_replace("/[^0-9.]/", "", $_POST['timedelay']);
$maxsize = preg_replace("/[^0-9.]/", "", $_POST["maxsize"]);
$maxamount = preg_replace("/[^0-9.]/", "", $_POST["maxamount"]);

$post_max_size = strval(intval($maxsize) * intval($maxamount)) . "M";

shell_exec("./changeconfig.sh " . $maxsize . "M " . $post_max_size . " " . $timedelay . " " . $maxamount);
header('location: config.html');
exit();