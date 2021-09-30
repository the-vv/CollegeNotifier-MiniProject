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

if ($cid) {
    $college = get_college($cid);
    if (count($college) > 0) {
        $college = $college[0];
    } else {
        $error_mess = 'College Missmatch Error';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
    $Mapper = new RoomStudentMap();
    $rids = $Mapper->get_rooms_of_student($cid, $student['id']);
    $tr = array();
    foreach ($rids as $r) {
        array_push($tr, $r['room_id']);
    }
    $rids = $tr;
}

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

?>
<div class="row p-1">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="p-0 m-0">
                Available Forms assigned for you
            </h5>
        </div>
    </div>
</div>
<ul class="list-group">
    <?php foreach ($allforms as $form) {
        echo "
        <li class='list-group-item d-flex justify-content-between align-items-center'>
            <a href='forms/render?fid={$form['id']}&{$url_with_query_params}' style='text-decoration:none' class='strong stretched-link d-flex align-items-center'>
                <div class='h6 d-block text-truncate d-flex align-items-center'><i class='bi bi-input-cursor-text me-2' style='font-size:1.5em;'></i>{$form['title']}</div>
            </a>
        </li>
        ";
    } ?>
</ul>