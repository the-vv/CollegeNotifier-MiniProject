<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/department.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/college.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/batch.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/class.php';
$user = get_current_logged_user();
if (isset($query_params['id'])) {    
    if (!isset($query_params['did'])) {
        $error_mess = 'Department Id not provided';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
    if (!isset($query_params['cid'])) {
        $error_mess = 'College Id not provided';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
    if (!isset($query_params['bid'])) {
        $error_mess = 'Batch Id not provided';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
    $department = get_dpt($query_params['did'])[0];
    echo "dept"; print_r($department);
    $college = get_college($query_params['cid'])[0];
    echo "<br>college"; print_r($college);
    $batch = get_batch($query_params['bid'])[0];
    echo "<br>batch"; print_r($batch);
    $class = get_a_class($query_params['id'])[0];
    echo "<br>class"; print_r($class);
    if($class['batch_id'] != $batch['id']) {
        $error_mess = 'Batch Id mismatch';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
    if($class['college_id'] != $college['id']) {
        $error_mess = 'College Id mismatch';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
    if($college['owner_id'] != $user['id']) {
        $error_mess = 'College Id mismatch';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
    if (count($class) < 1) {
        $error_mess = 'Class Id is invalid, Please try again';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
    require_once 'students.php';
} else {
    $error_mess = 'Class Id not provided';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
}
