<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/college.php';
$user = get_current_logged_user();
if(isset($query_params['cid'])) {
    $college = get_college($query_params['cid']);
    // print_r($college);
    if(count($college) < 1) {
        $error_mess = 'College Id is invalid, Please try again';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    } else {
        require_once 'departments.php';
    }
}
else{
    $error_mess = 'College Id not provided';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
}
?>
