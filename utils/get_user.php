<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/admin.php';
function get_current_logged_user()
{
    if (isset($_COOKIE['adminUser'])) {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/hashing.php';
        $email = decrypt($_COOKIE['adminUser']);
        $res = find_admin_user($email);
        if(!isset($res[0])) {
            header('Location:/logout');
        }
        if (!isset($res[0]['error'])) {
            unset($res[0]['admin_password']);
            $res[0]['type'] = 'admin';
            return $res[0];
        }
        return $res;
    } elseif (isset($_COOKIE['facultyUser'])) {
        $user = array();
        $user['type'] = 'faculty';
        $email = $_COOKIE['facultyUser'];
        return $user;
    } elseif (isset($_COOKIE['parentUser'])) {
        $user = array();
        $user['type'] = 'parent';
        $email = $_COOKIE['parentUser'];
        return $user;
    } elseif (isset($_COOKIE['studentUser'])) {
        $user = array();
        $user['type'] = 'student';
        $email = $_COOKIE['studentUser'];
        return $user;
    }
}
