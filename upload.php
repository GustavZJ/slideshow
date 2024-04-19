<?php
$target_dir = "uploads/";
echo "<script>console.log('" . json_encode($_FILES) . "');</script>";
foreach(range(0, count($_FILES['files']['name']) - 1) as $x) {
  $target_file = $target_dir . basename($_FILES['files']["name"][$x]);
$imageFileType = strtolower($_FILES['files']['type'][$x]);

// Check if image file is an actual image or fake image
if (isset($_POST["submit"])) {
  $check = getimagesize($_FILES['files']["tmp_name"][$x]);
  if ($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    header("Location: index.html?response=notImage");
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
}

// Check file size
if ($_FILES['files']["size"][$x] > 500000) {
  echo "Sorry, your file is too large.";
  header("Location: index.html?response=tooLarge");
}

// Allow certain file formats
if (!str_contains($imageFileType, 'image')) {
  echo "Sorry, " . $imageFileType . ' is not allowed';
  header("Location: index.html?response=notAllowed");
}

// Check if $uploadOk is set to 0 by an error
if (move_uploaded_file($_FILES['files']["tmp_name"][$x], $target_file)) {
  echo "The file " . htmlspecialchars(basename($_FILES['files']["name"][$x])) . " has been uploaded.";
  header("Location: index.html?response=success");
} else {
  echo "Sorry, there was an error uploading your file.";
  header("Location: index.html?response=error");
}
}

?>