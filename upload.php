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
      $response .= basename($_FILES['files']['name'][$x]) . '§isNotAnImage§';
    }
  
    // Check if file already exists
    if (file_exists($target_file)) {
      $uploadOk = 0;
      $response .= basename($_FILES['files']['name'][$x]) . '§fileExists§';
    }
  
    // Check file size
    if ($_FILES['files']["size"][$x] > 500000) {
      $uploadOk = 0;
      $response .= basename($_FILES['files']['name'][$x]) . '§isTooLarge§';
    }
  
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 1) {
      if (move_uploaded_file($_FILES['files']["tmp_name"][$x], $target_file)) {
        header("Location: index.html?response=success");
      } else {
        $response .= basename($_FILES['files']['name'][$x]) . '§unknownError§';
        header("Location: index.html?response={$response}");
      }
    } else {
      header("Location: index.html?response={$response}");
    }
  }
  exit();
?>