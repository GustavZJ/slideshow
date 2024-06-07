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

// Calculate autoremovetime based on the option
switch ($autoremovetimeoption) {
    case "days":
        // Convert the number of days into years, months, and days
        $years = intdiv($autoremovetimepost, 365); // Calculate the number of years
        $remainingDaysAfterYears = $autoremovetimepost % 365; // Remaining days after extracting years
        $months = intdiv($remainingDaysAfterYears, 31); // Calculate the number of months from the remaining days
        $days = $remainingDaysAfterYears % 31; // Remaining days after extracting months
        // Format the autoremovetime in the format YYYYMMDD
        $autoremovetime = $years * 10000 + $months * 100 + $days;
        break;
    case "months":
        // Convert the number of months into total days, then into years, months, and days
        $totalDays = $autoremovetimepost * 31; // Assume each month has 31 days
        $years = intdiv($totalDays, 365); // Calculate the number of years from total days
        $remainingDaysAfterYears = $totalDays % 365; // Remaining days after extracting years
        $months = intdiv($remainingDaysAfterYears, 31); // Calculate the number of months from the remaining days
        $days = $remainingDaysAfterYears % 31; // Remaining days after extracting months
        // Format the autoremovetime in the format YYYYMMDD
        $autoremovetime = $years * 10000 + $months * 100 + $days;
        break;
    case "years":
        // Convert the number of years into total days, then into years, months, and days
        $totalDays = $autoremovetimepost * 365; // Assume each year has 365 days
        $years = intdiv($totalDays, 365); // Calculate the number of years from total days
        $remainingDaysAfterYears = $totalDays % 365; // Remaining days after extracting years
        $months = intdiv($remainingDaysAfterYears, 31); // Calculate the number of months from the remaining days
        $days = $remainingDaysAfterYears % 31; // Remaining days after extracting months
        // Format the autoremovetime in the format YYYYMMDD
        $autoremovetime = $years * 10000 + $months * 100 + $days;
        break;
    default:
        // Default value in case of an error or unrecognized option
        $autoremovetime = 600; // Default to 600 (represents 6 months)
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
