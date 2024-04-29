<?php
  // Load php ini file to read max file size
  $iniFile = parse_ini_file('php.ini');

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

  $target_dir = "uploads/";
  $response = '';
  foreach(range(0, count($_FILES['files']['name']) - 1) as $x) {
    $target_file = $target_dir . basename($_FILES['files']["name"][$x]);
    $imageFileType = strtolower($_FILES['files']['type'][$x]);
    echo "<script>console.log('Debug Objects: " .json_encode($_FILES['files']['type'][$x]) . "' );</script>";
    $uploadOk = 1;

    // Check if image file is an actual image or fake image
    if (!str_contains($imageFileType, 'image')) {
      $uploadOk = 0;
      $response .= str_replace("_", "-", basename($_FILES['files']['name'][$x])) . '_isNotAnImage_';
    }
  
    // Check if file already exists
    if (file_exists($target_file)) {
      $uploadOk = 0;
      $response .= str_replace("_", "-", basename($_FILES['files']['name'][$x])) . '_fileExists_';
    }
  
    // Check if file is too large
    if ($_FILES['files']["size"][$x] > 200000) {
      $uploadOk = 0;
      $response .= str_replace("_", "-", basename($_FILES['files']['name'][$x])) . '_isTooLarge_';
    }

    if ($uploadOk){
      if (move_uploaded_file($_FILES['files']["tmp_name"][$x], $target_file)) {
        $response .= str_replace("_", "-", basename($_FILES['files']['name'][$x])) . '_success_';
      } else {
        $response .= str_replace("_", "-", basename($_FILES['files']['name'][$x])) . '_unknownError_';
      }
    }
  }

  // Return to upload page
  // header("Location: index.html?response={$response}");
  exit();
?>