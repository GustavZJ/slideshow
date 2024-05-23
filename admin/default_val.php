<?php
/**
 * Function to find the value for a given key in a .config file
 *
 * @param string $filePath The path to the .config file
 * @param string $key The key to search for
 * @return string|null The value of the key if found, or null if not found
 */
function getConfigValue($filePath, $key)
{
    if (!file_exists($filePath)) {
        throw new Exception("File not found: $filePath");
    }

    $configContent = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($configContent as $line) {
        // Skip comments and empty lines
        if (strpos(trim($line), '#') === 0 || strpos(trim($line), ';') === 0) {
            continue;
        }

        // Split the line by the first occurrence of '='
        $parts = explode('=', $line, 2);
        if (count($parts) == 2) {
            $currentKey = trim($parts[0]);
            $value = trim($parts[1]);

            if ($currentKey === $key) {
                return $value;
            }
        }
    }

    return null; // Return null if the key is not found
}

// Example usage
$filePath = '/var/www/slideshow/config.config';
$keys = array("timedelay");
$key_val = array();

foreach ($keys as $key) {
    try {
        $value = getConfigValue($filePath, $key);
        if ($value !== null) {
            array_push($key_val, $value);
        } else {
            array_push($key_val, "error");
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

header("Content-Type: application/json");
echo json_encode($key_val);
exit();