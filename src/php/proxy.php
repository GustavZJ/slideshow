<?php
// proxy.php
header('Access-Control-Allow-Origin: *');

$url = filter_var($_GET['url'], FILTER_VALIDATE_URL);
if (!$url) {
    http_response_code(400);
    echo 'Invalid URL';
    exit;
}

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
$response = curl_exec($ch);

if ($response === false) {
    http_response_code(500);
    echo 'Error fetching URL';
    exit;
}

$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
header("Content-Type: $contentType");
echo $response;

curl_close($ch);