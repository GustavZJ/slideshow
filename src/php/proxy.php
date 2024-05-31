<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if a 'url' parameter is passed in the query string
if (isset($_GET['url'])) {
    $url = $_GET['url'];

    if (filter_var($url, FILTER_VALIDATE_URL) === false) {
        echo "Invalid URL";
        exit();
    }

    $headers = @get_headers($url, 1);

    if ($headers === false) {
        echo "Failed to retrieve headers.";
        exit();
    }

    // Check if the content type is an image
    if (isset($headers['Content-Type']) && strpos($headers['Content-Type'], 'image/') === 0) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $html = curl_exec($ch);

        // Check for cURL errors
        if(curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
        } else {
            // Set the appropriate content type and display the image content
            header("Content-Type: " . $headers['Content-Type']);
            echo $html;
        }

        curl_close($ch);
    } else {
        // Initialize a cURL session for non-image content
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

        $result = curl_exec($ch);

        // Check for cURL errors
        if(curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
            curl_close($ch);
            exit();
        }

        // Retrieve the content type of the response
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        if ($contentType === false) {
            echo "Failed to retrieve content type.";
            curl_close($ch);
            exit();
        }

        curl_close($ch);

        // Set the appropriate content type and display the content
        header("Content-Type: $contentType");
        echo $result;
    }
} else {
    echo "No URL provided";
}
exit();