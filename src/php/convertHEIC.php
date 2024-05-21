<?php
$outputFiles = array();

function convertHeicWithHeifConvert($filePath) {
    $outputPath = $filePath . '.jpg';
    $command = "heif-convert $filePath $outputPath";
    exec($command, $output, $return_var);
    if ($return_var === 0) {
        echo "$filePath converted successfully to $outputPath\n";
        array_push($outputFiles, $outputPath);
    } else {
        echo "Error converting $filePath\n";
    }
}

function convertHeic() {
    $directory = '/var/www/slideshow/temp/';
    if (!is_dir($directory)) {
        echo "Directory does not exist: $directory\n";
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
// Load php ini file to read max file size
$iniFile = parse_ini_file('/var/www/slideshow/php.ini');

// Convert php ini max file size to bytes, so we can compare to image file size
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

// echo "<script>console.log('Debug Objects: " .json_encode($iniFile) . "' );</script>";
// echo "<script>console.log('Debug Objects: " .json_encode(convertToBytes($iniFile['upload_max_filesize'])) . "' );</script>";

$target_dir = "../temp/";
foreach(range(0, count($_FILES['files']['name']) - 1) as $x) {
$target_file = $target_dir . basename($_FILES['files']["name"][$x]);
$imageFileType = strtolower($_FILES['files']['type'][$x]);
$uploadOk = 1;
$response[basename($_FILES['files']['name'][$x])] = [];

// Check if image file is an actual image or fake image
if (!str_contains($imageFileType, 'image')) {
    $uploadOk = 0;
    array_push($response[basename($_FILES['files']['name'][$x])], 'er ikke et billede');
}

// Check if file already exists
if (file_exists($target_file)) {
    $uploadOk = 0;
    array_push($response[basename($_FILES['files']['name'][$x])], 'eksisterer allerede');
}

// Check if file is too large
if ($_FILES['files']["size"][$x] > convertToBytes($iniFile['upload_max_filesize'])) {
    $uploadOk = 0;
    array_push($response[basename($_FILES['files']['name'][$x])], 'er for stor');
}

if ($uploadOk){
    if (move_uploaded_file($_FILES['files']["tmp_name"][$x], $target_file)) {
    array_push($response[basename($_FILES['files']['name'][$x])], 'success');
    } else {
    array_push($response[basename($_FILES['files']['name'][$x])], 'ukendt fejl :(');
    }
}
}

convertHeic();

header('Content-Type: application/json');
echo $outputFiles;
exit();