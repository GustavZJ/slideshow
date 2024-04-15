<html>
<body>

<?php
$img_url = "https://i.ytimg.com/vi/wSdT-SArM2Q/maxresdefault.jpg";
function getimg($url)
{
  $headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
  $headers[] = 'Connection: Keep-Alive';
  $headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
  $user_agent = 'php';
  $process = curl_init($url);
  curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($process, CURLOPT_HEADER, 0);
  curl_setopt($process, CURLOPT_USERAGENT, $user_agent); //check here         
  curl_setopt($process, CURLOPT_TIMEOUT, 30);
  curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
  $return = curl_exec($process);
  curl_close($process);
  return $return;
}

$imagename = basename($img_url);
if (file_exists('uploads/' . $imagename)) {
  echo 'File already exists';
}

$image = getimg($img_url);
file_put_contents('uploads/' . $imagename, $image);

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
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
?>


</body>
</html>