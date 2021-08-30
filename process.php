<?php

declare(strict_types=1);

use Instagram\Api;
use Instagram\Exception\InstagramException;

use Instagram\Model\Media;
use Psr\Cache\CacheException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

require realpath(dirname(__FILE__)) . '/vendor/autoload.php';
$credentials = include_once realpath(dirname(__FILE__)) . '/credentials.php';

$cachePool = new FilesystemAdapter('Instagram', 0, __DIR__ . '/../cache');

$url = (string)filter_input(INPUT_POST, 'url');
$response = [
    'result' => '',
];

if ($url == '') {
    $response['result'] = 'The url param is missed';
    echo json_encode($response);
    exit(0);
}

try {
    $api = new Api($cachePool);
    $api->login($credentials->getLogin(), $credentials->getPassword());

    $media = new Media();
    $media->setLink($url);

    $mediaDetailed = $api->getMediaDetailed($media);
    $response['result'] = $mediaDetailed->getDisplayResources();
    echo json_encode($response);
} catch (InstagramException $e) {
    print_r($e->getMessage());
} catch (CacheException $e) {
    print_r($e->getMessage());
}
