<?php
  // Load php ini file to read max file size
  $iniFile = parse_ini_file('php.ini');

  // echo "<script>console.log('Debug Objects: " .json_encode($iniFile) . "' );</script>";

  $target_dir = "uploads/";
  $response = '';
  foreach(range(0, count($_FILES['files']['name']) - 1) as $x) {
    $target_file = $target_dir . basename($_FILES['files']["name"][$x]);
    $imageFileType = strtolower($_FILES['files']['type'][$x]);
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
    if ($_FILES['files']["size"][$x] > $iniFile['upload_max_filesize']) {
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
  header("Location: index.html?response={$response}");
  exit();
?>