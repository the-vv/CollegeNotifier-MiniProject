<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
$user = get_current_logged_user();
// print_r($user);
?>

<div class="container-fluid bg-light mx-md-4 shadow rounded " id="departments" style="min-height: 85vh">
    <ol class="breadcrumb" style="--bs-breadcrumb-divider: '>';">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item">My Profile</li>
    </ol>
    <div class="row mb-5 ">
        <!-- <div class="col-12">
            <h2 class="text-center">
                My Profle
            </h2>
        </div> -->
        <div class="col-12 text-center">
        <i class="bi bi-person-circle" style="font-size: 5rem;" class="text-primary"></i>
        </div>
        <div class="col-12  text-center">
            <h3 class="text-center">
                <?php echo $user['name'] ?>
            </h3>
            <p class="text-center mb-0 pb-0">
                <?php echo $user['email'] ?>
            </p>
            <small class="text-capitalize mx-auto fw-bolder">
                <?php echo $user['type'] ?>
            </small>
        </div>
    </div>
</div>