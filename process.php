<?php

require_once __DIR__ . '/vendor/autoload.php';

use Ayesh\InstagramDownload\InstagramDownload;

$response = [];
$url = (string)filter_input(INPUT_POST, 'url');

if ($url === '') {
    $response['result'] = 'The url param is missed.';
    echo json_encode($response);
    exit(0);
}

try {
    $client = new InstagramDownload($url);
    $downloadedUrl = $client->getDownloadUrl();
    $type = $client->getType();
    $response['result'] = $downloadedUrl;
} catch (\InvalidArgumentException $exception) {
    $error = $exception->getMessage();
    $response['error'] = $error;
} catch (\RuntimeException $exception) {
    $error = $exception->getMessage();
    $response['error'] = $error;
}

echo json_encode($response);
