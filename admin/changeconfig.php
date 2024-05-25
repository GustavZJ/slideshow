<?php
echo ("<script>console.log('PHP: " . json_encode($_POST) . "');</script>");


$timedelay = preg_replace("/[^0-9.]/", "", $_POST['timedelay']);
$maxsize = preg_replace("/[^0-9.]/", "", $_POST["maxsize"]);
$maxamount = preg_replace("/[^0-9.]/", "", $_POST["maxamount"]);
$autoremoveamount = preg_replace("/[^0-9.]/", "", $_POST["removeimagesamount"]);
$autoremovetime_post = preg_replace("/[^0-9.]/", "", $_POST["removeimagestime"]);
$autoremovetime_option = preg_replace("/[^0-9.]/", "", $_POST["removeimagestimeperiod"]);; # Add the option from post

$autoremove = false;
$autoremove_post = preg_replace("/[^0-9.]/", "", $_POST['removeimagestoggle']); // =on not true
if ($autoremove_post == "on") {
    $autoremove = "true";
}
else {
    $autoremove = "false";
}

switch ($autoremovetime_option) {
    case "days":
      $autoremovetime = intval($autoremovetime_post);
      break;
    case "months":
        $autoremovetime = intval($autoremovetime_post)*100;
      break;
    case "years":
        $autoremovetime = intval($autoremovetime_post)*10000;
      break;
    default:
    $autoremovetime = 600;
  }




$post_max_size = strval(intval($maxsize) * intval($maxamount)) . "M";

$command = "./changeconfig.sh " . $maxsize . "M " . $post_max_size . " " . $maxamount . " " . $timedelay. " " . $autoremove. " " . $autoremoveamount. " " . $autoremovetime;

shell_exec($command);
header('location: config.html');
exit();