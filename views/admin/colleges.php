<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/college.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
$user = get_current_logged_user();
$colleges = get_colleges($user['id']);
?>

<div class="container-fluid bg-light mx-md-4 shadow rounded border pt-2" id="departments" style="min-height: 85vh">
    <ol class="breadcrumb"  style="--bs-breadcrumb-divider: '>';">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Colleges</a></li>
    </ol>
    <div class="row mt-4 text-center">
        <h2>
            Welcome, <?php echo $user['name'] ?>
        </h2>
        <h6>
            <?php echo $user['email'] ?>
        </h6>
    </div> 
    <div class="row">
        <div class="col-10 mx-auto">
            <div class="row p-1 mt-5">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h5 class="p-0 m-0"> Colleges managed by you</h5>
                    <span>
                        <a href="college/create" class="btn btn-outline-primary rounded rounded-pill btn-sm"
                            class="btn btn-info strong">
                            Create <i class="bi bi-plus-lg"></i>
                        </a>
                    </span>
                </div>
            </div>
            <ul class="list-group">
                <?php foreach ($colleges as $college) {
                    echo "
                    <li class='list-group-item d-flex justify-content-between align-items-center'>
                    <a href='college?cid={$college['id']}' style='text-decoration: none' class='py-2 strong stretched-link'>
                    <div class='h6 d-block text-truncate'><i class='bi bi-building me-3'></i>{$college['college_name']}</div>
                        </a>
                    </li>
                    ";
                } ?>
            </ul>
        </div>
    </div>
</div>