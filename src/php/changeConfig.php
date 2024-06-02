<?php
// Get root of web
$docRoot = $_SERVER['DOCUMENT_ROOT'];

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
$autoremove = isset($_POST['autoremove']) && $_POST['autoremove'] === "on" ? "true" : "false";

// Calculate autoremovetime based on option
switch ($autoremovetimeoption) {
    case "days":
        $autoremovetime = intval($autoremovetimepost);
        $excessdays = ($autoremovetime % 1200) % 31;
        $excessmonths = ((($autoremovetime - ($excessdays)) / 31) * 100);
        $years = ((($autoremovetime - ($autoremovetime % 12)) / 12) * 100) + $autoremovetime % 12;
        $autoremovetime = $years * 10000 + $excessmonths * 100 + $excessdays;
        break;
    case "months":
        $autoremovetime = intval($autoremovetimepost) * 100;
        $autoremovetime = ((($autoremovetime - ($autoremovetime % 12)) / 12) * 100) + $autoremovetime % 12;
        break;
    case "years":
        $autoremovetime = intval($autoremovetimepost) * 10000;
        break;
    default:
        $autoremovetime = 600; // Default value in case of an error
}
if ($autoremovetime > 100000) {
    $autoremove = false;
}

// Calculate post_max_size
$post_max_filesize = strval(intval($maxsize) * intval($maxamount));
if (intval($post_max_filesize) > 1024) {
    $post_max_filesize = "20G";
} else {
    $post_max_filesize .= "M";
}

// Construct the command
$command = escapeshellcmd($docRoot . "/src/bash/changeConfig.sh") . " " . escapeshellarg($maxsize . "M") . " " . escapeshellarg($post_max_filesize) . " " . escapeshellarg($maxamount) . " " . escapeshellarg($timedelay) . " " . escapeshellarg($autoremove) . " " . escapeshellarg($autoremoveamount) . " " . escapeshellarg($autoremovetime) . " " . escapeshellarg($autoremovetimepost) . " " . escapeshellarg($autoremovetimeoption);

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
