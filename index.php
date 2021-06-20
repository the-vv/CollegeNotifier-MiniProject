<?php

$request = $_SERVER['REQUEST_URI'];

$parts = parse_url($request);
$query_params = null;
if (isset($parts['query'])) {
    parse_str($parts['query'], $query_params);
}

$query_param_values = array(
    'cid' => isset($query_params['cid']) ? $query_params['cid'] : 0,
    'did' => isset($query_params['did']) ? $query_params['did'] : 0,
    'bid' => isset($query_params['bid']) ? $query_params['bid'] : 0,
    'clid' => isset($query_params['clid']) ? $query_params['clid'] : 0,
    'rid' => isset($query_params['rid']) ? $query_params['rid'] : 0
);


$url_with_query_params = "";
if ($query_param_values['cid'] != 0) {
    $url_with_query_params = $url_with_query_params . "&cid=" . $query_param_values['cid'];
}
if ($query_param_values['did'] != 0) {
    $url_with_query_params = $url_with_query_params . "&did=" . $query_param_values['did'];
}
if ($query_param_values['bid'] != 0) {
    $url_with_query_params = $url_with_query_params . "&bid=" . $query_param_values['bid'];
}
if ($query_param_values['clid'] != 0) {
    $url_with_query_params = $url_with_query_params . "&clid=" . $query_param_values['clid'];
}
if ($query_param_values['rid'] != 0) {
    $url_with_query_params = $url_with_query_params . "&rid=" . $query_param_values['rid'];
}
if (strlen($url_with_query_params) > 1) {
    $url_with_query_params = substr($url_with_query_params, 1);
}

$request = explode('?', $request)[0];
// Use variable $query_params for query params

// Api Routing Begins here 
if (strpos($request, 'services') == 1) {
    switch ($request) {
        case '/services/students/deleteone':
            require_once __DIR__ . '/api/delete_student.php';
            break;
    }
    die();
}


require_once __DIR__ . './public/header.php';

// Normal Routing Begins Here
switch ($request) {
    case '':
    case '/':
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
    case '/students/edit':
        require_once __DIR__ . '/views/students/edit.php';
        break;
    case '/students/map':
        require_once __DIR__ . '/views/students/map.php';
        break;
    case '/administration/students':
        require_once __DIR__ . '/views/admininstration/students.php';
        break;
    default:
        http_response_code(404);
        require_once __DIR__ . '/views/404.php';
        break;
}

require_once __DIR__ . './public/footer.html';
