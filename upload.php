<?php
  $iniFile = parse_ini_file('php.ini');

  function convertToBytes(string $from): ?int {
    $units = ['B', 'K', 'M', 'G', 'T', 'P'];
    $number = substr($from, 0, -2);
    $suffix = strtoupper(substr($from,-2));

    //B or no suffix
    if(is_numeric(substr($suffix, 0, 1))) {
        return preg_replace('/[^\d]/', '', $from);
    }

    $exponent = array_flip($units)[$suffix] ?? null;
    if($exponent === null) {
        return null;
    }

    return $number * (1024 ** $exponent);
}

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
  
    // Check file size
    if ($_FILES['files']["size"][$x] > convertToBytes($iniFile['upload_max_filesize'])) {
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
  header("Location: index.html?response={$response}");
  exit();
?>