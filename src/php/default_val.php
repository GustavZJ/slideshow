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

function getKeyValue($filePath, $keys)
{
    $key_val = []; // Initialize the associative array to store values
    foreach ($keys as $key) {
        try {
            $value = getConfigValue($filePath, $key);
            if ($value !== null) {
                $key_val[$key] = preg_replace("/[^0-9.]/", "", $value);
            } else {
                $key_val[$key] = "error";
            }
        } catch (Exception $e) {
            $key_val[$key] = "error"; // Add "error" if exception occurs
        }
    }
    return $key_val;
}

$config_config_data = getKeyValue('/var/www/slideshow/config.config', array("timedelay", "autoremove", "autoremoveamount", "autoremovetime", "autoremoveoption", "autoremovepost"));
$php_ini_data = getKeyValue('/var/www/slideshow/php.ini', array("upload_max_filesize", "max_file_uploads"));
$key_vals = array_merge($config_config_data, $php_ini_data);

header("Content-Type: application/json");
echo json_encode($key_vals); // Corrected to use associative array
exit();