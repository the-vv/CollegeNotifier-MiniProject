<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/department.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/college.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/batch.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';

$user = get_current_logged_user();
$college = get_college($query_params['cid'])[0];
$department = get_dpt($query_params['id'])[0];
$batches = get_batches($college['id'], $department['id']);
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
                <li class="breadcrumb-item"><a href="college?id=<?php echo$query_params['cid'] ?>"><?php echo $department['dpt_name'] ?></a></li>
                <li class="breadcrumb-item"><a href="#">Batches</a></li>
            </ol>
        </nav>
    </div>
    <div class="row mb-5">
        <div class="h4 text-center mb-4 mt-3">
            Batches managed by you
        </div>
        <ul class="list-group px-5">
            <?php foreach ($batches as $batch) {
                echo "
                <li class='list-group-item d-flex justify-content-between align-items-center'>
                    <div class='h6 d-block text-truncate'>{$batch['start_year']} - {$batch['end_year']} Batch</div>
                    <a href='batch?id={$batch['id']}&cid={$query_params['cid']}&did={$query_params['id']}' class='btn btn-success px-md-5 strong'>
                        Go
                    </a>
                </li>
                ";
            } ?>
            <li class="list-group-item d-flex justify-content-evenly align-items-center bg-secondary text-white">
                <span class="h5">Create a Batch now:</span>
                <a href="batch/create?cid=<?php echo $query_params['cid'] ?>&did=<?php echo $query_params['id'] ?>" class="btn btn-info px-md-5 strong">
                    Create
                </a>
            </li>
        </ul>
    </div>
</div>