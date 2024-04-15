

<?php 
  
// Create a new imagick object 
$imagickAnimation = new Imagick( 
'https://media.geeksforgeeks.org/wp-content/uploads/20191117194549/g4ganimatedcolor.gif'); 
  
// Show the output 
header("Content-Type: image/gif"); 
  
echo $imagickAnimation->getImagesBlob(); 
?> 
