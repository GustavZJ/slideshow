<?php
// Sanitize input
$timedelay = preg_replace("/[^0-9.]/", "", $_POST['timedelay']);
$maxsize = preg_replace("/[^0-9.]/", "", $_POST["maxsize"]);
$maxamount = preg_replace("/[^0-9.]/", "", $_POST["maxamount"]);
$autoremoveamount = preg_replace("/[^0-9.]/", "", $_POST["autoremoveamount"]);
$autoremovetimepost = preg_replace("/[^0-9.]/", "", $_POST["autoremovetimepost"]);

// Ensure autoremovetimeoption is valid
$valid_options = ["days", "months", "years"];
$autoremovetimeoption = $_POST["autoremovetimeoption"];
if (!in_array($autoremovetimeoption, $valid_options)) {
    $autoremovetimeoption = "days"; // Default to "days" or handle error as needed
}

// Determine autoremove
$autoremove = isset($_POST['removeimagestoggle']) && $_POST['removeimagestoggle'] === "on" ? "true" : "false";

// Calculate autoremovetime based on option
switch ($autoremovetimeoption) {
    case "days":
        $autoremovetime = intval($autoremovetimepost);
        break;
    case "months":
        $autoremovetime = intval($autoremovetimepost) * 100;
        break;
    case "years":
        $autoremovetime = intval($autoremovetimepost) * 10000;
        break;
    default:
        $autoremovetime = 600; // Default value in case of an error
}

// Calculate post_max_size
$post_max_size = strval(intval($maxsize) * intval($maxamount)) . "M";

// Construct the command
$command = escapeshellcmd("./changeconfig.sh") . " " . escapeshellarg($maxsize . "M") . " " . escapeshellarg($post_max_size) . " " . escapeshellarg($maxamount) . " " . escapeshellarg($timedelay) . " " . escapeshellarg($autoremove) . " " . escapeshellarg($autoremoveamount) . " " . escapeshellarg($autoremovetime) . " " . escapeshellarg($autoremovetimepost) . " " . escapeshellarg($autoremovetimeoption);

// Execute the command and capture the exit code
$return_var = 0;
exec($command, $output, $return_var);

// Prepare the response
$response = [
    'exit_code' => $return_var
];

header('Content-Type: application/json');
echo json_encode($response);
exit();
