<?php

require $_SERVER['DOCUMENT_ROOT'] . '/dbActions/department.php';
require $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
$user = get_current_logged_user();
$departments = get_colleges($user['id']);
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
            departments managed by you
        </div>
        <ul class="list-group px-5">
            <?php foreach ($departments as $dept) {
                echo "
                <li class='list-group-item d-flex justify-content-between align-items-center'>
                    <div class='h6 d-block text-truncate'>{$dept['college_name']}</div>
                    <a href='college?id={$dept['id']}' class='btn btn-success px-md-5 strong'>
                        Go
                    </a>
                </li>
                ";
            } ?>
            <li class="list-group-item d-flex justify-content-evenly align-items-center bg-secondary text-white">
                <span class="h5">Create a Department now:</span>
                <a href="college/create" class="btn btn-info px-md-5 strong">
                    Create
                </a>
            </li>
        </ul>
    </div>
</div>