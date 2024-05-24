<?php
  // Load php ini file to read max file size
  $iniFile = parse_ini_file('../php.ini');

  // Convert php ini max file size to bytes, so we can compare to image file size
  function convertToBytes($value) {
    return preg_replace_callback('/^\s*(\d+)\s*(?:([kmgt]?)b?)?\s*$/i', function ($m) {
      switch (strtolower($m[2])) {
        case 't': $m[1] *= 1024;
        case 'g': $m[1] *= 1024;
        case 'm': $m[1] *= 1024;
        case 'k': $m[1] *= 1024;
      }
      return $m[1];
    }, $value);
  }

  // echo "<script>console.log('Debug Objects: " .json_encode($iniFile) . "' );</script>";
  // echo "<script>console.log('Debug Objects: " .json_encode(convertToBytes($iniFile['upload_max_filesize'])) . "' );</script>";
  if (count($_FILES['files']['name']) > $iniFile["max_file_uploads"]) {
    $response = "For mange filer!!!:("
  }
  else {
    $targetDir = "../uploads/";
    $response = array();
    foreach(range(0, count($_FILES['files']['name']) - 1) as $x) {
      $filename = basename($_FILES['files']["name"][$x]);
      $newFilename = date("Ymd") . $filename . $ext;
      $targetFile = $targetDir . $newFilename;
      $imageFileType = strtolower($_FILES['files']['type'][$x]);
      $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    
      $response[basename($_FILES['files']['name'][$x])] = [];
      $uploadOk = 1;
    
      // Check if image file is an actual image or fake image
      if (!str_contains($imageFileType, 'image')) {
        $uploadOk = 0;
        array_push($response[basename($_FILES['files']['name'][$x])], 'er ikke et billede');
      }
    
      // Check if file already exists
      if (file_exists($targetFile)) {
        $uploadOk = 0;
        array_push($response[basename($_FILES['files']['name'][$x])], 'eksisterer allerede');
      }
    
      // Check if file is too large
      if ($_FILES['files']["size"][$x] > convertToBytes($iniFile['upload_max_filesize'])) {
        $uploadOk = 0;
        array_push($response[basename($_FILES['files']['name'][$x])], 'er for stor');
      }
    
      if ($uploadOk){
        if (move_uploaded_file($_FILES['files']["tmp_name"][$x], $targetFile)) {
          array_push($response[basename($_FILES['files']['name'][$x])], 'success');
        } else {
          array_push($response[basename($_FILES['files']['name'][$x])], 'ukendt fejl :(');
        }
      }
    }
  }
  // Return to upload page
  header('Content-Type: application/json');
  echo json_encode($response);
  exit();