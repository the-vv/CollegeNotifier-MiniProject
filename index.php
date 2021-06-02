<?php

$request = $_SERVER['REQUEST_URI'];

require __DIR__ . './common/header.html' ;

switch ($request) {
    case '/' :
        require __DIR__ . '/views/index.php';
        break;
    case '' :
        require __DIR__ . '/views/index.php';
        break;
    case '/admin' :
        require __DIR__ . '/views/adminIndex.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}

require __DIR__ . './common/footer.html' ;