<?php
$return_var = 0;
exec("/var/www/slideshow/src/bash/restoreBackup.sh", $output, $return_var);

// Prepare the response
$response = [
    'exit_code' => $return_var
];

header('Content-Type: application/json');
echo json_encode($response);
exit();
