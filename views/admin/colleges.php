<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/college.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
$user = get_current_logged_user();
$colleges = get_colleges($user['id']);
?>

<div class="container shadow rounded border" id="colleges" style="min-height: 80vh">
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
                <li class="breadcrumb-item"><a href="#">Colleges</a></li>
            </ol>
        </nav>
    </div>
    <div class="row mb-5">
        <div class="h4 text-center mb-4 mt-3">
            Colleges managed by you
        </div>
        <ul class="list-group px-5">
            <?php foreach ($colleges as $college) {
                echo "
                    <li class='list-group-item d-flex justify-content-between align-items-center'>
                        <div class='h6 d-block text-truncate'><i class='bi bi-building me-3'></i>{$college['college_name']}</div>
                        <a href='college?cid={$college['id']}' class='btn btn-success px-md-5 strong'>
                            Go
                        </a>
                    </li>
                    ";
                }?>
            <li class="list-group-item d-flex justify-content-evenly align-items-center bg-secondary text-white">
                <span class="h5">Create a college now:</span>
                <a href="college/create" class="btn btn-info px-md-5 strong">
                    Create
                </a>
            </li>
        </ul>
    </div>
</div>
