<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

    if (isset($headers['Content-Type']) && strpos($headers['Content-Type'], 'image/') === 0) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $html = curl_exec($ch);

        if(curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
        } else {
            header("Content-Type: " . $headers['Content-Type']);
            echo $html;
        }

        curl_close($ch);
    } else {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        $result = curl_exec($ch);

        if(curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
            curl_close($ch);
            exit();
        }

        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        if ($contentType === false) {
            echo "Failed to retrieve content type.";
            curl_close($ch);
            exit();
        }

        curl_close($ch);

        header("Content-Type: $contentType");
        echo $result;
    }
} else {
    echo "No URL provided";
}
exit();