<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/department.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/college.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/batch.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/student.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';

$user = get_current_logged_user();
$college = get_college($query_params['cid'])[0];
$department = get_dpt($query_params['did'])[0];
$batches = get_batches($college['id'], $department['id']);
$students = get_students_from_dpt($query_params['did']);
// print_r($batches);
?>


<div class="container shadow rounded border" id="departments" style="min-height: 80vh">
    <div class="row mt-4 text-center">
        <h2>
            Welcome, <?php echo $user['admin_name'] ?>
        </h2>
        <h6>
            <?php echo $user['email'] ?>
        </h6>
    </div>
    <div class="d-flex justify-content-center border pt-2 rounded">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="admin"><?php echo $college['college_name'] ?></a></li>
                <li class="breadcrumb-item"><a
                        href="college?cid=<?php echo$query_params['cid'] ?>"><?php echo $department['dpt_name'] ?></a>
                </li>
                <li class="breadcrumb-item"><a href="#">Batches</a></li>
            </ol>
        </nav>
    </div>
    <div class="row mb-5">
        <div class="col-md-8">
            <div class="h4 text-center mb-4 mt-3">
                <?php echo $college['college_name'] ?> Dashboard
            </div>
            <div class="row p-1 align-items-end">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h6 class="p-0 m-0">Events/ Announcements in College level</h6>
                    <span>
                        <button type="button" class="btn btn-outline-primary rounded rounded-pill btn-sm">
                            Create <i class="bi bi-plus-lg"></i>
                        </button>
                    </span>
                </div>
            </div>
            <ul class="list-group">
                <li class='list-group-item d-flex justify-content-between align-items-center'>
                    <a href="#" class="d-inline-block text-truncate h6 text-decoration-none">
                        Here is the event content
                        <small class="small text-muted">
                            | Content description
                        </small>
                    </a>
                </li>
                <li class='list-group-item d-flex justify-content-between align-items-center'>
                    <a href="#" class="d-inline-block text-truncate h6 text-decoration-none">
                        Here is the event content
                        <small class="small text-muted">
                            | Content description
                        </small>
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="h4 text-center mb-4 mt-3">
                    Batches managed by you
                </div>
                <ul class="list-group">
                    <?php foreach ($batches as $batch) {
                    echo "
                    <li class='list-group-item d-flex justify-content-between align-items-center'>
                        <a href='batch?bid={$batch['id']}&cid={$query_params['cid']}&did={$query_params['did']}' style='text-decoration:none' class='strong'>
                            <div class='h6 d-block text-truncate'><i class='fas fa-graduation-cap me-1'></i>{$batch['start_year']} - {$batch['end_year']} Batch</div>
                        </a>
                    </li>
                    ";
                } ?>
                    <li
                        class="list-group-item d-flex justify-content-between align-items-center bg-secondary text-white">
                        <span class="h5">Create one:</span>
                        <a href="batch/create?cid=<?php echo $query_params['cid'] ?>&did=<?php echo $query_params['did'] ?>"
                            class="btn btn-info strong">
                            Create
                        </a>
                    </li>
                </ul>
            </div>
            <div class="row my-3">
                <div class="col-12 text-center mb-3">
                    <span class="h4">Total of <?php echo count($students); ?> Students Added</span>
                </div>
                <div class="col-6 text-center">
                    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/students/list.php';?>
                </div>
                <div class="col-6 text-center">
                    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/students/create.php';?>
                </div>
            </div>
        </div>
    </div>