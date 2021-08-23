<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/hashing.php';

if (!isset($_COOKIE['adminUser'])) {
    header('Location:admin/login');
    // echo "<script type='text/javascript'>location.href = 'admin/login';</script>";
} else {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/db/admin.php';
    $user = find_admin_user(decrypt($_COOKIE['adminUser']));
    if (count($user) < 1) {
        header('Location:/logout');
    }
    else {
        require_once 'colleges.php';
    }
}
