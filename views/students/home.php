<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/department.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/college.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/batch.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/student.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/room_student_map.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/rooms.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';

if (!isset($_COOKIE[CookieNames::student])) {
   die( header('Location:student/login'));
} else {
    authorize_student();
    $student = get_current_logged_user();
    if (!(isset($student['type']) && $student['type'] == 'student')) {
        $error_mess = 'Error verifying student, Please logout and login again';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
}
$cid = $student['college_id'] ?? 0;
$did = $student['dpt_id'] ?? 0;
$bid = $student['batch_id'] ?? 0;
$clid = $student['class_id'] ?? 0;
$rids = array();

$college = array();
$department = array();
$batch = array();
$class = array();
$rooms = array();
// $student = array();


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
    // print_r($rids);
    // echo '<br>';
}
if ($did) {
    $department = get_dpt($did);
    if (count($department) > 0) {
        $department = $department[0];
    } else {
        $error_mess = 'Department Missmatch Error';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
}
if ($bid) {
    $batch = get_batch($bid);
    if (count($batch) > 0) {
        $batch = $batch[0];
    } else {
        $error_mess = 'Batch Missmatch Error';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
}

$students = array();

if ($clid) {
    // echo $clid;
    $class = get_a_class($clid);
    // print_r($class);
    if (count($class) > 0) {
        $class = $class[0];
    } else {
        $error_mess = 'Class Missmatch Error';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
    $students = get_students_from_class($clid);
}

// $students = get_students_from_college($college['id']);
$RoomMapper = new RoomStudentMap();
foreach($rids as $r) {
    $sts = $RoomMapper->get_all_students_in_room($college['id'], $r);
    foreach($sts as $s) {
        array_push($students, $s);
    }
    $Room = new Rooms();
    $tmp_room = $Room->get_one($r)[0];
    array_push($rooms, $tmp_room);
}
$tempIds = array();
$students = array_filter($students, function($s) {
    global $tempIds;
    if (array_search($s['id'], $tempIds) !== false) {
        return false;
    }
    else {
        array_push($tempIds, $s['id']);
        return true;
    }
});
// print_r($students);
// print_r($college);
// echo "<br>";
// print_r($department);
// echo "<br>";
// print_r($rooms);
// echo "<br>";
// print_r($class);
?>

<div class="container-fluid bg-light mx-md-4 pt-2 shadow rounded" id="rooms" style="min-height: 85vh">
    <ol class="breadcrumb" style="--bs-breadcrumb-divider: '>';">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $college['college_name'] ?></a></li>
        <?php if ($did) { ?>
            <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $department['dpt_name'] ?></a></li>
        <?php } ?>
        <?php if ($bid) { ?>
            <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo "{$batch['start_year']} - {$batch['end_year']} Batch" ?></a></li>
        <?php } ?>
        <?php if ($clid) { ?>
            <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo "Class {$class['division']}" ?></a></li>
        <?php } ?>
        <li class="breadcrumb-item">Dashboard</li>
    </ol>
    <?php if (!$clid) { ?>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                </symbol>
            </svg>
            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-3" width="24" height="24" role="img" aria-label="Warning:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div class="">
                    Warning: You are not part of any Class!
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php } ?>
    <div class="row mb-5 mt-2">
        <div class="col-12">
            <div class="h4 text-center mb-3">
                Your College Dashboard
            </div>
        </div>
        <div class="col-md-8">
            <?php require_once 'events_view.php' ?>
        </div>
        <div class="col-md-4">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="students-tab" data-bs-toggle="tab" data-bs-target="#students" type="button" role="tab" aria-controls="students" aria-selected="false">Students</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="batch-tab" data-bs-toggle="tab" data-bs-target="#batch" type="button" role="tab" aria-controls="batch" aria-selected="true">Faculties</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="batch" role="tabpanel" aria-labelledby="batch-tab">
                    <div class="row p-1 align-items-end">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <h5 class="p-0 m-0">Faculties Feature is Coming Soon!</h5>
                            <!-- <span>
                                <a href="batch/create?<?php echo $url_with_query_params ?>" class="btn btn-outline-primary rounded rounded-pill btn-sm" class="btn btn-info strong">
                                    Create <i class="bi bi-plus-lg"></i>
                                </a>
                            </span> -->
                        </div>
                    </div>
                    <ul class="list-group">
                        <!-- <?php //foreach ($batches as $batch) {
                        //             echo "
                        // <li class='list-group-item d-flex justify-content-between align-items-center'>
                        //     <a href='batch?bid={$batch['id']}&{$url_with_query_params}' style='text-decoration:none' class='strong stretched-link'>
                        //         <div class='h6 d-block text-truncate'><i class='fas fa-graduation-cap me-1'></i>{$batch['start_year']} - {$batch['end_year']} Batch</div>
                        //     </a>
                        // </li>
                        // ";
                                // } ?> -->
                    </ul>
                </div>
                <div class="tab-pane fade show active" id="students" role="tabpanel" aria-labelledby="students-tab">
                    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/students/list.php'; ?>
                </div>
            </div>
        </div>
    </div>
</div>