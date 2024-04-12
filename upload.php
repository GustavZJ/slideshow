<html>
<body>

<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["name"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is an actual image or fake image
if (isset($_POST["submit"])) {
  $check = getimagesize($_FILES["name"]["tmp_name"]);
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
if ($_FILES["name"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["name"]["tmp_name"], $target_file)) {
    echo "The file " . htmlspecialchars(basename($_FILES["name"]["name"])) . " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

echo '<br>File info: ' . print_r($_FILES);
echo '<br>BaseName: ' . $_FILES["name"]["name"];
echo '<br>File: ' . $target_file . '<br>';

$dirFiles = scandir($target_dir);
foreach ($dirFiles as $dirFile) {
  if (is_file($target_dir . $dirFile)) {
    echo $dirFile . "<br>";
  }
}
?>

</body>
</html>