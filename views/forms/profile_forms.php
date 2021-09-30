<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/department.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/college.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/batch.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/student.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/room_student_map.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/rooms.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';

$cid = $student['college_id'] ?? 0;
$did = $student['dpt_id'] ?? 0;
$bid = $student['batch_id'] ?? 0;
$clid = $student['class_id'] ?? 0;
$rids = array();

$collegeforms = array();
$dptforms = array();
$batchforms = array();
$classforms = array();
$roomforms = array();
$allforms = array();

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/form.php';

// variables used below are coming from parent home.php
if ($cid) {
    $collegeforms = get_forms_by_param($cid);
    foreach ($rids as $r) {
        $te = get_forms_by_room($cid, $r);

        foreach ($te as $t) {
            array_push($roomforms, $t);
        }
    }
    // print_r($roomforms);
}
if ($did) {
    $dptforms = get_forms_by_param($cid, $did);
}
if ($bid) {
    $batchforms = get_forms_by_param($cid, $did, $bid);
}
if ($clid) {
    $classforms = get_forms_by_param($cid, $did, $bid, $clid);
}

$allforms = array_merge($collegeforms, $dptforms, $batchforms, $classforms, $roomforms);
