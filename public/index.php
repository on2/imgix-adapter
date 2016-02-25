<?php

require __DIR__ . '/../vendor/autoload.php';

if (!getenv('BASE_URI')) {
    $dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
    $dotenv->load();
}

$baseUri = getenv('BASE_URI');
$regexp = '/^([cr])([0-9]+)x([0-9]+)\/((?:.+)\.(?:jpg|png|gif))$/';

$uri = $_SERVER['REQUEST_URI'];
if (substr($uri, 0, strlen($baseUri)) == $baseUri) {
    $uri = substr($uri, strlen($baseUri));
}

if (preg_match($regexp, $uri, $matches) !== 1) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    exit('404');
}

$path = $matches[4];

$params = [];

if ($matches[2] != 0) {
    $params['w'] = $matches[2];
}

if ($matches[3] != 0) {
    $params['h'] = $matches[3];
}

$params['trim'] = 'color';
$params['fit'] = ($matches[1] == 'r' ? 'clip' : 'crop');

$builder = new \Imgix\UrlBuilder(getenv('IMGIX_DOMAIN'));
$builder->setSignKey(getenv('IMGIX_SIGN_KEY'));
$url = $builder->createURL($matches[4], $params);

$target = __DIR__ . '/' . $matches[1] . $matches[2] . 'x' . $matches[3] . '/' . $path;
$dir = dirname($target);

if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

$image = file_get_contents($url);
$length = file_put_contents($target, $image);

switch (pathinfo($target, PATHINFO_EXTENSION)) {
    case "jpg" : $mime = "image/jpeg"; break;
    case "png" : $mime = "image/png";  break;
    case "gif" : $mime = "image/gif";  break;
}

header("Content-Type: " . $mime);
echo $image;
