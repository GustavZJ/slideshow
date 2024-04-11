
<html>
<body>
<?php

$target_path = "/home/panda/Pictures/";
$target_path = $target_path . basename( $_FILES['uploadedfile']['name']);

echo "Source=" .      $_FILES['uploadedfile']['name'] . "<br />";
echo "Destination=" .   $destination_path . "<br />";
echo "Target path=" .   $target_path . "<br />";
echo "Size=" .      $_FILES['uploadedfile']['size'] . "<br />";

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
echo "The file ".  basename( $_FILES['uploadedfile']['name']).
" has been uploaded";
} else{
echo "There was an error uploading the file, please try again!";
}
?> 
</body>
</html>