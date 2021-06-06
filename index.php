<?php

$request = $_SERVER['REQUEST_URI'];

$parts = parse_url($request);
$query_params = null;
if(isset($parts['query'])) {
    parse_str($parts['query'], $query_params);
}

$request = explode('?', $request)[0];
 // Use $query_params for query params

require __DIR__ . './public/header.php';

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
    case '/college':
        require __DIR__ . '/views/college/index.php';
        break;
    case '/college/create':
        require __DIR__ . '/views/college/create.html';
        break;
    case '/college/submit':
        require __DIR__ . '/views/college/submit.php';
    break;    
    case '/faculty':
        require __DIR__ . '/views/faculty/index.php';
        break;
    case '/faculty/login':
        require __DIR__ . '/views/faculty/login.html';
        break;
    case '/faculty/signup':
        require __DIR__ . '/views/faculty/signup.html';
        break;
    case '/faculty/submit':
        require __DIR__ . '/views/faculty/submit.php';
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
