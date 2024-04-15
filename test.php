<?php
$target_dir = "uploads/";

foreach($_FILES as $x) {
    $target_file = $target_dir . basename($x["name"]);
    $uploadOk = 1;
$imageFileType = strtolower($_FILES['file']['type']);

// Check if image file is an actual image or fake image
if (isset($_POST["submit"])) {
  $check = getimagesize($_FILES["file"]["tmp_name"]);
  if ($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["file"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if (!str_contains($imageFileType, 'image')) {
  echo "Sorry, " . $imageFileType . ' is not allowed';
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    echo "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

echo "<script>console.log('" . json_encode($_FILES) . "');</script>";
echo '<br>BaseName:'.$_FILES["file"]["name"];
echo '<br>File:'. $target_file.'<br>';
$dirFiles = scandir($target_dir);
foreach ($dirFiles as $dirFile) {
  $filePath = $dirPath . '/' . $file;
  if (is_file($filePath)) {
      echo $file . "<br>";
  }
}    
}

?>