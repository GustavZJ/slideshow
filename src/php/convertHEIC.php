<?php

// Load php.ini file to read max file size
$iniFile = parse_ini_file("/var/www/slideshow/php.ini");
$target_dir = "/var/www/slideshow/temp/";
$response = array("upload" => array(), "convert" => array());
$outputFiles = array();

// Convert php.ini max file size to bytes
function convertToBytes($value) {
    return preg_replace_callback("/^\s*(\d+)\s*(?:([kmgt]?)b?)?\s*$/i", function ($m) {
        switch (strtolower($m[2])) {
            case "t": $m[1] *= 1024;
            case "g": $m[1] *= 1024;
            case "m": $m[1] *= 1024;
            case "k": $m[1] *= 1024;
        }
        return $m[1];
    }, $value);
}

foreach (range(0, count($_FILES["hidden"]["name"]) - 1) as $x) {
    $file = basename($_FILES["hidden"]["name"][$x]);
    $target_file = $target_dir . $file;
    $imageFileType = strtolower(pathinfo($_FILES["hidden"]["name"][$x], PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Check if file is an actual image (basic check by MIME type)
    if (!str_contains($imageFileType, "image")) {
        $uploadOk = 0;
        $response["upload"][$file][] = "er ikke et billede".$imageFileType;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
        $response["upload"][$file][] = "eksisterer allerede";
    }

    // Check if file is too large
    if ($_FILES["hidden"]["size"][$x] > convertToBytes($iniFile["upload_max_filesize"])) {
        $uploadOk = 0;
        $response["upload"][$file][] = "er for stor";
    }

    if ($uploadOk) {
        if (move_uploaded_file($_FILES["hidden"]["tmp_name"][$x], $target_file)) {
            $response["upload"][$file][] = "success";
        } else {
            $response["upload"][$file][] = "ukendt fejl :(";
        }
    }
}

function convertHeicWithHeifConvert($filePath) {
    global $response, $outputFiles; // Add global keyword to access these arrays
    $outputPath = $filePath . ".jpg";
    $command = "heif-convert " . escapeshellarg($filePath) . " " . escapeshellarg($outputPath);
    exec($command, $output, $return_var);
    if ($return_var === 0) {
        array_push($outputFiles, $outputPath);
        // unlink($filePath);
        $response["convert"][$filePath][] = "Success";
    } else {
        $response["convert"][$filePath][] = "Fejl";
    }
}

function convertHeic() {
    global $response; // Add global keyword to access the response array
    $directory = "/var/www/slideshow/temp/";
    if (!is_dir($directory)) {
        $response["convert"][$directory][] = "Eksistere ikke";
        return;
    }

    $files = scandir($directory);

    foreach($files as $file) {
        $filePath = $directory . $file;
        if (is_file($filePath) && strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) === "heic") {
            convertHeicWithHeifConvert($filePath);
        }
    }
}

convertHeic();

header("Content-Type: application/json");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");
echo json_encode(array("files" => $outputFiles, "response" => $response));
exit();