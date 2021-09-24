<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
$user = get_current_logged_user();
// print_r($user);
?>

<div class="container-fluid bg-light mx-md-4 shadow rounded mb-3" id="departments" style="min-height: 85vh">
    <ol class="breadcrumb" style="--bs-breadcrumb-divider: '>';">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item">My Profile</li>
    </ol>
    <div class="row">
        <div class="col-6 text-end">
            <i class="bi bi-person-circle" style="font-size: 5rem;" class="text-primary"></i>
        </div>
        <div class="col-6 d-flex align-items-center">
            <div class="col-12">
                <h3 class="">
                    <?php echo $user['name'] ?>
                </h3>
                <p class="mb-0 pb-0">
                    <?php echo $user['email'] ?>
                </p>
                <small class="text-capitalize fw-bolder">
                    <?php echo $user['type'] ?>
                </small>
            </div>
        </div>
    </div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit" type="button"
                role="tab" aria-controls="edit" aria-selected="true">Edit Profile</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="forms-tab" data-bs-toggle="tab" data-bs-target="#forms" type="button"
                role="tab" aria-controls="forms" aria-selected="false">Profile Forms</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="edit" role="tabpanel" aria-labelledby="edit-tab">
            <div class="row">
                <?php if($user['type'] === UserTypes::student) {
            $student = $user;
            $sid = $user['id'];
            $cid = $user['college_id'];
            require_once $_SERVER['DOCUMENT_ROOT'] . '/views/students/edit.php';
        } ?>
            </div>
        </div>
        <div class="tab-pane fade" id="forms" role="tabpanel" aria-labelledby="forms-tab">
            Profile Forms
        </div>
    </div>

</div>