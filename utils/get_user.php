<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/admin.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/student.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/hashing.php';
function get_current_logged_user()
{
    if (isset($_COOKIE[CookieNames::admin])) {
        $email = decrypt($_COOKIE[CookieNames::admin]);
        $res = find_admin_user($email);
        if (!isset($res[0])) {
            header('Location:/logout');
        }
        if (!isset($res[0]['error'])) {
            unset($res[0]['admin_password']);
            $res[0]['type'] = UserTypes::admin;
            return $res[0];
        }
        return $res;
    } elseif (isset($_COOKIE[CookieNames::faculty])) {
        $user = array();
        $user['type'] = UserTypes::faculty;
        return $user;
    } elseif (isset($_COOKIE[CookieNames::parent])) {
        $user = array();
        $user['type'] = UserTypes::parent;
        return $user;
    } elseif (isset($_COOKIE[CookieNames::student])) {
        $email = decrypt($_COOKIE[CookieNames::student]);
        $res = find_student_by_email($email);
        if (!isset($res[0])) {
            header('Location:/logout');
        }
        if (!isset($res[0]['error'])) {
            unset($res[0]['admin_password']);
            $res[0]['type'] = UserTypes::student;
            return $res[0];
        }
        return $res;
    } else {
        // header('Location:/logout');
        return false; // for is logged in checking
    }
}
