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

convertHeic();

header('Content-Type: application/json');
echo $outputFiles;
exit();