<?php
if (isset($_GET['url'])) {
    $url = $_GET['url'];
    $headers = get_headers($url, 1);

    // Validate URL
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        // Initialize a cURL session
        $ch = curl_init();

        // Set the URL
        curl_setopt($ch, CURLOPT_URL, $url);

        // Set options to return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Follow redirects
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        // Set the user agent to mimic a browser
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

        // Execute the session and store the contents in a variable
        $result = curl_exec($ch);

        // Get the content type of the response
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

        // Close the cURL session
        curl_close($ch);

        // Set the appropriate headers
        header("Content-Type: $contentType");
        echo $result;
    } else if (isset($headers['Content-Type']) && strpos($headers['Content-Type'], 'image/') === 0) {
        header("Content-Type: " . $headers['Content-Type']);
        readfile($url);
    } else {
        echo "Invalid URL";
    }
} else {
    echo "No URL provided";
}