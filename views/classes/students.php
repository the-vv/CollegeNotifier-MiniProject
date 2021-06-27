<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/department.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/college.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/batch.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/student.php';
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
        <li class="breadcrumb-item"><a href="college?cid=<?php echo $query_params['cid'] ?>"><?php echo $department['dpt_name'] ?></a>
        </li>
        <li class="breadcrumb-item"><a href="department?did=<?php echo $query_params['did'] ?>&cid=<?php echo $query_params['cid'] ?>"><?php echo "{$batch['start_year']} - {$batch['end_year']} Batch" ?></a>
        </li>
        <li class="breadcrumb-item"><a href="batch?bid=<?php echo $query_params['bid'] ?>&did=<?php echo $query_params['did'] ?>&cid=<?php echo $query_params['cid'] ?>">Division
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
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/students/list.php'; ?>
        </div>
    </div>
</div>