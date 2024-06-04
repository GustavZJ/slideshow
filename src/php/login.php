<?php
session_start();
ob_start(); // Start output buffering

// Function to read the .htpasswd file and return an associative array of username => hashed_password
function get_htpasswd_credentials($file_path) {
    if (!file_exists($file_path)) {
        throw new Exception("The file $file_path does not exist.");
    }
    
    $lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if ($lines === false) {
        throw new Exception("Failed to open the file $file_path.");
    }

    $credentials = [];
    foreach ($lines as $line) {
        if (strpos($line, ':') !== false) {
            list($username, $hash) = explode(':', $line, 2);
            $credentials[$username] = $hash;
        }
    }

    return $credentials;
}

// Path to the .htpasswd file
$htpasswd_file = '/etc/apache2/.htpasswd';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
        $password = $_POST['password'];
        $credentials = get_htpasswd_credentials($htpasswd_file);

        // Check user credentials
        if (isset($credentials['uploader']) && password_verify($password, $credentials['uploader'])) {
            $_SESSION['role'] = 'uploader';
            header('Location: /landing.php');
            ob_end_flush(); // Flush the output buffer
            exit(); // Ensure no further code is executed
        }
        // Check admin credentials
        elseif (isset($credentials['admin']) && password_verify($password, $credentials['admin'])) {
            $_SESSION['role'] = 'admin';
            header('Location: /landing.php');
            ob_end_flush(); // Flush the output buffer
            exit(); // Ensure no further code is executed
        } else {
            $response = ["error" => "Invalid password."];
        }
    }
} catch (Exception $e) {
    $response = ["error" => $e->getMessage()];
}

if (isset($response)) {
    header('Content-Type: application/json');
    echo json_encode($response);
    ob_end_flush(); // Flush the output buffer
}
?>
