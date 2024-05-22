<?php

// Load php.ini file to read max file size
$iniFile = parse_ini_file('/var/www/slideshow/php.ini');

// Convert php.ini max file size to bytes
function convertToBytes($value) {
    return preg_replace_callback('/^\s*(\d+)\s*(?:([kmgt]?)b?)?\s*$/i', function ($m) {
        switch (strtolower($m[2])) {
            case 't': $m[1] *= 1024;
            case 'g': $m[1] *= 1024;
            case 'm': $m[1] *= 1024;
            case 'k': $m[1] *= 1024;
        }
        return $m[1];
    }, $value);
}

$target_dir = "/var/www/slideshow/temp/";
$errorStr = '';
foreach (range(0, count($_FILES['hidden']['name']) - 1) as $x) {
    $target_file = $target_dir . basename($_FILES['hidden']["name"][$x]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Check if file is an actual image (basic check by MIME type)
    if (!str_contains($imageFileType, 'image')) {
        $uploadOk = 0;
        $errorStr .= basename($_FILES['hidden']['name'][$x]) . " is not an image.\n";
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
        $errorStr .= basename($_FILES['hidden']['name'][$x]) . " already exists.\n";
    }

    // Check if file is too large
    if ($_FILES['hidden']["size"][$x] > convertToBytes($iniFile['upload_max_filesize'])) {
        $uploadOk = 0;
        $errorStr .= basename($_FILES['hidden']['name'][$x]) . " is too large.\n";
    }

    $uploadOk = 1;

    if ($uploadOk) {
        if (move_uploaded_file($_FILES['hidden']["tmp_name"][$x], $target_file)) {
            $errorStr .= basename($_FILES['hidden']['name'][$x]) . " uploaded successfully.\n";
        } else {
            $errorStr .= "Unknown error occurred while uploading " . basename($_FILES['hidden']['name'][$x]) . ".\n";
        }
    }
}


$outputFiles = array();

function convertHeicWithHeifConvert($filePath) {
    global $outputFiles;
    $outputPath = $filePath . '.jpg';
    $command = "heif-convert $filePath $outputPath";
    exec($command, $output, $return_var);
    if ($return_var === 0) {
        array_push($outputFiles, $outputPath);
        unlink($filePath);
        // echo "$filePath converted successfully to $outputPath";
    } else {
        // echo "Error converting $filePath";
    }
}

function convertHeic() {
    $directory = '/var/www/slideshow/temp/';
    if (!is_dir($directory)) {
        // echo "Directory does not exist: $directory";
        return;
    }

    $files = scandir($directory);

    foreach($files as $file) {
        $filePath = $directory . $file;
        if (is_file($filePath) && strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) === 'heic') {
            convertHeicWithHeifConvert($filePath);
        }
    }
}



convertHeic();

header('Content-Type: application/json');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
echo json_encode($outputFiles);
exit();