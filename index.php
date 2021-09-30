<?php

ob_start();

// Global Constant Variables
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/globals.php';

date_default_timezone_set('Asia/Kolkata');

function str_end_with_str($haystack, $needle)
{
    $length = strlen($needle);
    if (!$length) {
        return true;
    }
    return substr($haystack, -$length) === $needle;
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SERVER['REQUEST_URI'] != '/index.php' && str_end_with_str($_SERVER['REQUEST_URI'], '.php')) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die(header('location: 404'));
}

$request = $_SERVER['REQUEST_URI'];

$parts = parse_url($request);
$query_params = null;
if (isset($parts['query'])) {
    parse_str($parts['query'], $query_params);
}

$query_param_values = array(
    'cid' => $query_params['cid'] ?? 0,
    'did' => $query_params['did'] ?? 0,
    'bid' => $query_params['bid'] ?? 0,
    'clid' => $query_params['clid'] ?? 0,
    'rid' => $query_params['rid'] ?? 0
);


$url_with_query_params = "";
foreach ($query_params as $param => $val) {
    $url_with_query_params = $url_with_query_params . "&$param=$val";
}
// if ($query_param_values['cid'] != 0) {
//     $url_with_query_params = $url_with_query_params . "&cid=" . $query_param_values['cid'];
// }
// if ($query_param_values['did'] != 0) {
//     $url_with_query_params = $url_with_query_params . "&did=" . $query_param_values['did'];
// }
// if ($query_param_values['bid'] != 0) {
//     $url_with_query_params = $url_with_query_params . "&bid=" . $query_param_values['bid'];
// }
// if ($query_param_values['clid'] != 0) {
//     $url_with_query_params = $url_with_query_params . "&clid=" . $query_param_values['clid'];
// }
// if ($query_param_values['rid'] != 0) {
//     $url_with_query_params = $url_with_query_params . "&rid=" . $query_param_values['rid'];
// }
if (strlen($url_with_query_params) > 1) {
    $url_with_query_params = substr($url_with_query_params, 1);
}

$request = explode('?', $request)[0];
// Use variable $query_params for query params

// Api Routing Begins here 
if (strpos($request, 'services') == 1) {
    switch ($request) {
        case '/services/students/deleteone':
            require_once $_SERVER['DOCUMENT_ROOT'] . '/api/delete_student.php';
            break;
        case '/services/events/getone':
            require_once $_SERVER['DOCUMENT_ROOT'] . '/api/get_event.php';
            break;
        case '/services/events/deleteone':
            require_once $_SERVER['DOCUMENT_ROOT'] . '/api/delete_event.php';
            break;
        case '/services/department/deleteone':
            require_once $_SERVER['DOCUMENT_ROOT'] . '/api/delete_dpt.php';
            break;
        case '/services/batch/deleteone':
            require_once $_SERVER['DOCUMENT_ROOT'] . '/api/delete_batch.php';
            break;
        case '/services/class/deleteone':
            require_once $_SERVER['DOCUMENT_ROOT'] . '/api/delete_class.php';
            break;
        case '/services/room/deleteone':
            require_once $_SERVER['DOCUMENT_ROOT'] . '/api/delete_room.php';
            break;
        default:
            http_response_code(404);
            echo json_encode(array('error' => true, 'message' => "Service Not found"));
    }
    die();
}


require_once $_SERVER['DOCUMENT_ROOT'] . '/public/header.php';

// Normal Routing Begins Here
switch ($request) {
    case '':
    case '/':
    case '/index.php':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/index.php';
        break;
    case '/admin':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/admin/index.php';
        break;
    case '/admin/login':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/admin/login.html';
        break;
    case '/admin/signup':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/admin/signup.html';
        break;
    case '/admin/submit':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/admin/submit.php';
        break;
    case '/college':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/college/index.php';
        break;
    case '/college/create':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/college/create.html';
        break;
    case '/college/submit':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/college/submit.php';
        break;
    case '/department':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/departments/index.php';
        break;
    case '/department/create':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/departments/create.php';
        break;
    case '/department/submit':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/departments/submit.php';
        break;
    case '/departments/edit':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/departments/edit.php';
        break;
    case '/batch':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/batch/index.php';
        break;
    case '/batch/create':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/batch/create.php';
        break;
    case '/batch/edit':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/batch/edit.php';
        break;
    case '/batch/submit':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/batch/submit.php';
        break;
    case '/class':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/classes/index.php';
        break;
    case '/class/create':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/classes/create.php';
        break;
    case '/class/edit':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/classes/edit.php';
        break;
    case '/class/submit':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/classes/submit.php';
        break;
    case '/logout':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/logout.php';
        break;
    case '/students/submit':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/students/submit.php';
        break;
    case '/students/edit':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/students/edit.php';
        break;
    case '/students/map':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/students/map.php';
        break;
    case '/students/map-room':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/students/map_room.php';
        break;
    case '/administration/students':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/admininstration/students.php';
        break;
    case '/administration/departments':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/admininstration/departments.php';
        break;
    case '/administration/batches':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/admininstration/batches.php';
        break;
    case '/administration/classes':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/admininstration/classes.php';
        break;
    case '/administration/rooms':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/admininstration/rooms.php';
        break;
    case '/events/create':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/events/create.php';
        break;
    case '/events/submit':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/events/submit.php';
        break;
    case '/rooms':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/rooms/index.php';
        break;
    case '/rooms/create':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/rooms/create.php';
        break;
    case '/rooms/edit':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/rooms/edit.php';
        break;
    case '/rooms/submit':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/rooms/submit.php';
        break;
    case '/forms/submit':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/forms/submit.php';
        break;
    case '/forms/create':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/forms/create.php';
        break;

        //Student User Routing Section
    case '/student':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/students/home.php';
        break;
    case '/student/login':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/students/login.php';
        break;

        // Common Routes
    case '/my-profile':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/my_profile.php';
        break;

        // Routing Ends with 404 here
    case '/404':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/404.php';
    default:
        http_response_code(404);
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/404.php';
        break;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/public/footer.php';

ob_end_flush();
