<?php

require $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
require $_SERVER['DOCUMENT_ROOT'] . '/dbActions/college.php';
$user = get_current_logged_user();
if(isset($query_params['id'])) {
    $college = get_college($query_params['id']);
    // print_r($college);
    if(count($college) < 1) {
        $error_mess = 'College Id is invalid, Please try again';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    }
}
else{
    $error_mess = 'College Id not provided';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
}
?>
