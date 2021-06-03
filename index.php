<?php

$request = $_SERVER['REQUEST_URI'];

require __DIR__ . './public/header.html';

switch ($request) {
    case '/':
        require __DIR__ . '/views/index.php';
        break;
    case '':
        require __DIR__ . '/views/index.php';
        break;
    case '/admin':
        require __DIR__ . '/views/admin/index.php';
        break;
    case '/admin/login':
        require __DIR__ . '/views/admin/login.html';
        break;
    case '/admin/signup':
        require __DIR__ . '/views/admin/signup.html';
        break;
    case '/admin/submit':
        require __DIR__ . '/views/admin/submit.php';
    break;
    case '/logout':
        require __DIR__ . '/utils/logout.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}

require __DIR__ . './public/footer.html';
