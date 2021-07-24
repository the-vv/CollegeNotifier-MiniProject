<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/admin.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/student.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/hashing.php';
function get_current_logged_user()
{
    if (isset($_COOKIE['adminUser'])) {
        $email = decrypt($_COOKIE['adminUser']);
        $res = find_admin_user($email);
        if (!isset($res[0])) {
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
        return $user;
    } elseif (isset($_COOKIE['parentUser'])) {
        $user = array();
        $user['type'] = 'parent';
        return $user;
    } elseif (isset($_COOKIE['studentUser'])) {
        $email = decrypt($_COOKIE['studentUser']);
        $res = find_student_by_email($email);
        if (!isset($res[0])) {
            header('Location:/logout');
        }
        if (!isset($res[0]['error'])) {
            unset($res[0]['admin_password']);
            $res[0]['type'] = 'student';
            return $res[0];
        }
        return $res;
    } else {
        return false; // for is logged in checking
    }
}
