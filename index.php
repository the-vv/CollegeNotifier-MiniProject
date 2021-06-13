<?php

$request = $_SERVER['REQUEST_URI'];

$parts = parse_url($request);
$query_params = null;
if (isset($parts['query'])) {
    parse_str($parts['query'], $query_params);
}

$request = explode('?', $request)[0];
// Use variable $query_params for query params

require_once __DIR__ . './public/header.php';

// Normal Routing Begins Here
switch ($request) {
    case '/':
        require_once __DIR__ . '/views/index.php';
        break;
    case '':
        require_once __DIR__ . '/views/index.php';
        break;
    case '/index.php':
        require_once __DIR__ . '/views/index.php';
        break;
    case '/admin':
        require_once __DIR__ . '/views/admin/index.php';
        break;
    case '/admin/login':
        require_once __DIR__ . '/views/admin/login.html';
        break;
    case '/admin/signup':
        require_once __DIR__ . '/views/admin/signup.html';
        break;
    case '/admin/submit':
        require_once __DIR__ . '/views/admin/submit.php';
        break;
    case '/college':
        require_once __DIR__ . '/views/college/index.php';
        break;
    case '/college/create':
        require_once __DIR__ . '/views/college/create.html';
        break;
    case '/college/submit':
        require_once __DIR__ . '/views/college/submit.php';
        break;
    case '/department':
        require_once __DIR__ . '/views/departments/index.php';
        break;
    case '/department/create':
        require_once __DIR__ . '/views/departments/create.php';
        break;
    case '/department/submit':
        require_once __DIR__ . '/views/departments/submit.php';
        break;
    case '/batch':
        require_once __DIR__ . '/views/batch/index.php';
        break;
    case '/batch/create':
        require_once __DIR__ . '/views/batch/create.php';
        break;
    case '/batch/submit':
        require_once __DIR__ . '/views/batch/submit.php';
        break;
    case '/class':
        require_once __DIR__ . '/views/classes/index.php';
        break;
    case '/class/create':
        require_once __DIR__ . '/views/classes/create.php';
        break;
    case '/class/submit':
        require_once __DIR__ . '/views/classes/submit.php';
        break;
    case '/logout':
        require_once __DIR__ . '/utils/logout.php';
        break;        
    case '/students/submit':
        require_once __DIR__ . '/views/students/submit.php';
        break;
    default:
        http_response_code(404);
        require_once __DIR__ . '/views/404.php';
        break;
}

require_once __DIR__ . './public/footer.html';
