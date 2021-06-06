<?php

require $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
require $_SERVER['DOCUMENT_ROOT'] . '/dbActions/department.php';
$user = get_current_logged_user();
if(isset($query_params['id'])) {
    $department = get_dpt($query_params['id']);
    print_r($department);
    if(count($department) < 1) {
        $error_mess = 'Department Id is invalid, Please try again';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    }
}
else{
    $error_mess = 'Department Id not provided';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
}
?>
