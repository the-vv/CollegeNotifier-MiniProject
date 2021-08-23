<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/department.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/college.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/batch.php';
$user = get_current_logged_user();
if (isset($query_params['bid'])) {    
    if (!isset($query_params['cid'])) {
        $error_mess = 'College Id not provided';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
    if (!isset($query_params['did'])) {
        $error_mess = 'Department Id not provided';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
    $department = get_dpt($query_params['did'])[0];
    // print_r($department);
    $college = get_college($query_params['cid'])[0];
    // print_r($college);
    $batch = get_batch($query_params['bid'])[0];
    // print_r($batch);
    if($batch['dpt_id'] != $department['id']) {
        $error_mess = 'Department Id mismatch';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
    if($batch['college_id'] != $college['id']) {
        $error_mess = 'Department Id mismatch';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
    if($college['owner_id'] != $user['id']) {
        $error_mess = 'College Id mismatch';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
    if (count($batch) < 1) {
        $error_mess = 'Department Id is invalid, Please try again';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
    require_once 'classes.php';
} else {
    $error_mess = 'Batch Id not provided';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
}
