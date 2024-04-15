<html>
<body>

<?php
echo "<script>console.log('" . json_encode($_POST['url']) . "');</script>";
$img_url = imagecreatefromstring($_POST['url']);
$image = new \Imagick($_POST['url']);
echo $image->getImagesBlob();
//$image->readimageblob($_POST['url']);
//echo '<img src="data:image/png;base64,' .  base64_encode($image->getimageblob())  . '" />';
function getimg($url)
{
  // $headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg, image/jpg, image/jpg';
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
?>


</body>
</html>