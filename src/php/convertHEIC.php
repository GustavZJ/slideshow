<?php

function convertHeic() {
    $directory = '/var/www/slideshow/temp/';
    $files = scandir($directory);

    foreach($files as $file) {
        $filePath = $directory . $file;
        
        if (is_file($filePath) && strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) === 'heic') {
            try {
                $outputPath = $filePath . '.jpg';
                HeicToJpg::convert($filePath, "", true)->saveAs($outputPath);
                echo "$filePath converted successfully to $outputPath\n";
            } catch (Exception $e) {
                echo "Error converting $filePath: " . $e->getMessage() . "\n";
            }
        }
    }
}

convertHeic();
// header('Content-Type: application/json');
// echo json_encode($convertedFile);
// exit();