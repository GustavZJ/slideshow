<?php

require '/var/www/slideshow/vendor/autoload.php'; // Make sure to include the Composer autoloader

use Maestroerror\HeicToJpg;

function convertHeic() {
    $directory = '/var/www/slideshow/temp/';
    $files = scandir($directory);

    foreach($files as $file) {
        $filePath = $directory . $file;
        
        if (is_file($filePath) && strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) === 'heic') {
            try {
                $outputPath = $filePath . '.jpg';
                HeicToJpg::convert($filePath, "arm64", true)->saveAs($outputPath);
                echo "$filePath converted successfully to $outputPath\n";
            } catch (Exception $e) {
                echo "Error converting $filePath: " . $e->getMessage() . "\n";
            }
        }
    }
}

convertHeic();