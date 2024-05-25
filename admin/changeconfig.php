<?php
echo ("<script>console.log('PHP: " . json_encode($_POST) . "');</script>");


$timedelay = preg_replace("/[^0-9.]/", "", $_POST['timedelay']);
$maxsize = preg_replace("/[^0-9.]/", "", $_POST["maxsize"]);
$maxamount = preg_replace("/[^0-9.]/", "", $_POST["maxamount"]);
$autoremove = preg_replace("/[^0-9.]/", "", $_POST['autoremove']);
$autoremoveamount = preg_replace("/[^0-9.]/", "", $_POST["autoremoveamount"]);
// $autoremovetime_post = preg_replace("/[^0-9.]/", "", $_POST["autoremovetime"]);
// $autoremovetime_option = null; # Add the option from post

// Testing
$autoremovetime_post = 5;
$autoremovetime_option = "days"; // Add the option from post
$autoremovetime = 600;
switch ($autoremovetime_option) {
    case "days":
      $autoremovetime = intval($autoremovetime_post);
      break;
    case "months":
        $autoremovetime = intval($autoremovetime_post)*10;
      break;
    case "years":
        $autoremovetime = intval($autoremovetime_post)*100;
      break;
    default:
    $autoremovetime = 600;
  }




$post_max_size = strval(intval($maxsize) * intval($maxamount)) . "M";

shell_exec("./changeconfig.sh " . $maxsize . "M " . $post_max_size . " " . $timedelay . " " . $autoremove. " " . $autoremoveamount. " " . $autoremovetime);
header('location: config.html');
exit();