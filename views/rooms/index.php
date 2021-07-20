<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/rooms.php';
$Room = new rooms();
$cid = $query_params['cid'] ?? 0;
$current_room = null;
if ($cid) {
    $rid = $query_params['rid'] ?? 0;
    if(!$rid) {
        $error_mess = 'Room id not provided';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
    $current_room = null;
    $current_room = $Room->get_one($rid);
    $current_room = $current_room[0] ?? null;
    if (!$current_room) {
        $error_mess = 'Incorrect Room id';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
    require_once 'home.php';
} else {
    $error_mess = 'College Id not provided';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}
