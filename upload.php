<?php
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
  
    // Check file size
    if ($_FILES['files']["size"][$x] > 500000) {
      $uploadOk = 0;
      $response .= str_replace("_", "-", basename($_FILES['files']['name'][$x])) . '_isTooLarge_';
    }
    if ($uploadOk){
      if (move_uploaded_file($_FILES['files']["tmp_name"][$x], $target_file)) {
        $response .= str_replace("_", "-", basename($_FILES['files']['name'][$x])) . '_successs_';
      } else {
        $response .= str_replace("_", "-", basename($_FILES['files']['name'][$x])) . '_unknownError_';
      }
    }
  }
  header("Location: index.html?response={$response}");
  exit();
?>