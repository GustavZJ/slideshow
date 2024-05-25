<?php
echo ("<script>console.log('PHP: " . json_encode($_POST) . "');</script>");


$timedelay = preg_replace("/[^0-9.]/", "", $_POST['timedelay']);
$maxsize = preg_replace("/[^0-9.]/", "", $_POST["maxsize"]);
$maxamount = preg_replace("/[^0-9.]/", "", $_POST["maxamount"]);
// $autoremove = preg_replace("/[^0-9.]/", "", $_POST['autoremove']);
// $autoremoveamount = preg_replace("/[^0-9.]/", "", $_POST["autoremoveamount"]);
// $autoremovetime_post = preg_replace("/[^0-9.]/", "", $_POST["autoremovetime"]);
// $autoremovetime_option = null; # Add the option from post

// Testing
$autoremove = "true";
$autoremoveamount = "30";
$autoremovetime_post = "5";
$autoremovetime_option = "days"; // Add the option from post
$autoremovetime = 600;
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
header('location: config.html/');
exit();