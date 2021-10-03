<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/department.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/college.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/batch.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/student.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
$user = get_current_logged_user();
$department = get_dpt($query_params['did'])[0];
$college = get_college($query_params['cid'])[0];
$batch = get_batch($query_params['bid'])[0];
$current_class = get_a_class($query_params['clid'])[0];
$students = get_students_from_class($current_class['id']);
// print_r($students);
?>

<div class="container-fluid bg-light mx-md-4 shadow rounded border" id="departments" style="min-height: 85vh">
    <ol class="breadcrumb" style="--bs-breadcrumb-divider: '>';">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="admin"><?php echo $college['college_name'] ?></a></li>
        <li class="breadcrumb-item"><a
                href="college?cid=<?php echo $query_params['cid'] ?>"><?php echo $department['dpt_name'] ?></a>
        </li>
        <li class="breadcrumb-item"><a
                href="department?did=<?php echo $query_params['did'] ?>&cid=<?php echo $query_params['cid'] ?>"><?php echo "{$batch['start_year']} - {$batch['end_year']} Batch" ?></a>
        </li>
        <li class="breadcrumb-item"><a
                href="batch?bid=<?php echo $query_params['bid'] ?>&did=<?php echo $query_params['did'] ?>&cid=<?php echo $query_params['cid'] ?>">Division
                <?php echo $class['division'] ?></a></li>
        <li class="breadcrumb-item"><a href="#">Students</a></li>
    </ol>
    <?php if ($user['type'] == 'admin') {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/admininstration/index.php';
    } ?>
    <div class="row mt-3" style="max-height: 90vh">
        <div class="col-12">
            <div class="h4 text-center mb-3 mt-3">
                Division <?php echo $class['division'] ?> Dashboard
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-md-8">
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/events/index.php' ?>
        </div>
        <div class="col-md-4">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="students-tab" data-bs-toggle="tab" data-bs-target="#students"
                        type="button" role="tab" aria-controls="students" aria-selected="false">Students</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#forms" type="button"
                        role="tab" aria-controls="forms" aria-selected="false">Forms</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane show active fade" id="students" role="tabpanel" aria-labelledby="students-tab">
                    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/students/list.php';?>
                </div>
                <div class="tab-pane fade" id="forms" role="tabpanel" aria-labelledby="forms-tab">
                    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/forms/index.php'; ?>
                </div>
            </div>
        </div>
    </div>
</div>