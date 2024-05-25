<?php

// Sanitize input
$timedelay = preg_replace("/[^0-9.]/", "", $_POST['timedelay']);
$maxsize = preg_replace("/[^0-9.]/", "", $_POST["maxsize"]);
$maxamount = preg_replace("/[^0-9.]/", "", $_POST["maxamount"]);
$autoremoveamount = preg_replace("/[^0-9.]/", "", $_POST["removeimagesamount"]);
$autoremovetime_post = preg_replace("/[^0-9.]/", "", $_POST["removeimagestime"]);
$autoremovetime_option = preg_replace("/[^0-9.]/", "", $_POST["removeimagestimeperiod"]);

// Determine autoremove
$autoremove = isset($_POST['removeimagestoggle']) && $_POST['removeimagestoggle'] === "on" ? "true" : "false";

// Calculate autoremovetime based on option
switch ($autoremovetime_option) {
    case "days":
        $autoremovetime = intval($autoremovetime_post);
        break;
    case "months":
        $autoremovetime = intval($autoremovetime_post) * 100;
        break;
    case "years":
        $autoremovetime = intval($autoremovetime_post) * 10000;
        break;
    default:
        $autoremovetime = 600;
}

// Calculate post_max_size
$post_max_size = strval(intval($maxsize) * intval($maxamount)) . "M";

// Construct the command
$command = escapeshellcmd("./changeconfig.sh") . " " . escapeshellarg($maxsize . "M") . " " . escapeshellarg($post_max_size) . " " . escapeshellarg($maxamount) . " " . escapeshellarg($timedelay) . " " . escapeshellarg($autoremove) . " " . escapeshellarg($autoremoveamount) . " " . escapeshellarg($autoremovetime);

// Execute the command
shell_exec($command);

// Redirect to config.html
header('Location: config.html');
exit();
