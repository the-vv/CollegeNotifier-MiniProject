<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/college.php';
function authorize_student()
{
    $user = get_current_logged_user();
    if (isset($user) && isset($user['type']) && $user['type'] == UserTypes::student) {
        return true;
    } else {
        ob_end_clean();
        require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/fullscreen_error_401.php';
        die();
    }
}

function authorize_admin()
{
    global $query_params;
    $user = get_current_logged_user();
    if (isset($user) && isset($user['type']) && $user['type'] == UserTypes::admin) {
        if (isset($query_params['cid'])) {
            $college = get_college($query_params['cid'])[0];
            if (isset($college) && $college['owner_id'] != $user['id']) {
                ob_end_clean();
                require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/fullscreen_error_401.php';
                die();
            } 
        }
        return true;
    } else {
        ob_end_clean();
        require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/fullscreen_error_401.php';
        die();
    }
}
