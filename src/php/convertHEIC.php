<?php

// function convertHeic() {
    
// }

$convertedFile = 'hello';

header('Content-Type: application/json');
echo json_encode($convertedFile);
exit();