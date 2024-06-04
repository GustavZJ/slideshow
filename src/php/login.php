<?php
session_start();

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
$response = '';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
        $password = $_POST['password'];
        $credentials = get_htpasswd_credentials($htpasswd_file);

        // Check user credentials
        if (isset($credentials['uploader']) && password_verify($password, $credentials['uploader'])) {
            $_SESSION['role'] = 'uploader';
            echo json_encode(['redirect' => '/landing.php']);
            exit();
        }
        // Check admin credentials
        elseif (isset($credentials['admin']) && password_verify($password, $credentials['admin'])) {
            $_SESSION['role'] = 'admin';
            echo json_encode(['redirect' => '/landing.php']);
            exit();
        } else {
            $response = ["message" => "Forkert kodeord."];
        }
    }
} catch (Exception $e) {
    $response = ["message" => $e->getMessage()];
}

if (isset($response)) {
    header('Content-Type: application/json');
    echo json_encode($response);
}