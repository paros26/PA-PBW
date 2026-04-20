<?php
// router.php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if ($uri !== '/' && (file_exists(__DIR__ . '/public' . $uri) || file_exists(__DIR__ . $uri))) {
    return false;
}

$_GET['url'] = ltrim($uri, '/');
require_once __DIR__ . '/public/index.php';
