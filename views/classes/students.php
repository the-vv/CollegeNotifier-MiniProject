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
$classes = get_classes($department['id'], $college['id'], $batch['id']);
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
    <hr>
    <div class="row mb-5">
        <div class="h4 text-center my-4">
            Classes managed by you
        </div>
        <ul class="list-group px-5">
            <?php foreach ($classes as $class) {
                echo "
                <li class='list-group-item d-flex justify-content-between align-items-center'>
                    <div class='h6 d-block text-truncate'>{$class['college_name']}</div>
                    <a href='college?id={$class['id']}' class='btn btn-success px-md-5 strong'>
                        Go
                    </a>
                </li>
                ";
            } ?>
            <li class="list-group-item d-flex justify-content-evenly align-items-center bg-secondary text-white">
                <span class="h5">Create a Class now:</span>
                <a href="class/create?cid=<?php echo $query_params['cid'] ?>&did=<?php echo $query_params['did'] ?>&bid=<?php echo $query_params['id'] ?>" class="btn btn-info px-md-5 strong">
                    Create
                </a>
            </li>
        </ul>
    </div>
</div>
