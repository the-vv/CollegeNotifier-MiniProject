<?php

require $_SERVER['DOCUMENT_ROOT'] . '/dbActions/admin.php';
function get_current_logged_user()
{
    if (isset($_COOKIE['adminUser'])) {
        $user = array();
        $user['type'] = 'admin';
        $email = $_COOKIE['adminUser'];
        $res = find_admin_user($email)[0];
        if (!isset($res['error'])) {
            unset($res['admin_password']);
            return $res;
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
