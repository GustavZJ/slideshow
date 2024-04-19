<?php
  $target_dir = "uploads/";
  foreach(range(0, count($_FILES['files']['name']) - 1) as $x) {
    $target_file = $target_dir . basename($_FILES['files']["name"][$x]);
    $imageFileType = strtolower($_FILES['files']['type'][$x]);
    header("Location: index.html?response=$imageFileType");

    // Check if image file is an actual image or fake image
    if (!str_contains($imageFileType, 'image')) {
      header("Location: index.html?response=notAllowed");
    }
  
    // Check if file already exists
    if (file_exists($target_file)) {
      header("Location: index.html?response=fileExists");
    }
  
    // Check file size
    if ($_FILES['files']["size"][$x] > 500000) {
      header("Location: index.html?response=tooLarge");
    }
  
    // Check if $uploadOk is set to 0 by an error
    if (move_uploaded_file($_FILES['files']["tmp_name"][$x], $target_file)) {
      header("Location: index.html?response=success");
    } else {
      header("Location: index.html?response=error");
    }
  }
?>