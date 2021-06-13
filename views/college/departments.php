<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/department.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/college.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/student.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
$user = get_current_logged_user();
$departments = get_dpts($query_params['cid']);
$college = get_college($query_params['cid'])[0];
$students = get_students_from_college($query_params['cid']);
?>

<div class="container shadow rounded border" id="departments" style="min-height: 80vh">
    <ol class="breadcrumb" style="--bs-breadcrumb-divider: '>';">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="admin"><?php echo $college['college_name'] ?></a></li>
        <li class="breadcrumb-item">Departments</li>
    </ol>
    <?php if ($user['type'] == 'admin') {?>
    <div class="row">
        <div class="col-12 mb-2">
            <p class="h4 text-center"><?php echo $college['college_name'] ?> Administration Tools</p>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-4">
                    <button class="btn btn-outline-dark rounded rounded-pill w-100"><i class='fas fa-building me-1'></i>
                        Departments
                    </button>
                </div>
                <div class="col-4">
                    <button class="btn btn-outline-dark rounded rounded-pill w-100"><i
                            class='fas fa-graduation-cap me-1'></i>
                        Batches
                    </button>
                </div>
                <div class="col-4">
                    <button class="btn btn-outline-dark rounded rounded-pill w-100"><i class="fas fa-user-graduate"></i>
                        Classes
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-4">
                    <button class="btn btn-outline-dark rounded rounded-pill w-100"><i
                            class="bi bi-house-door-fill"></i>
                        Rooms
                    </button>
                </div>
                <div class="col-4">
                    <button class="btn btn-outline-dark rounded rounded-pill w-100"><i class="fas fa-user-graduate"></i>
                        Faculties
                    </button>
                </div>
                <div class="col-4">
                    <button class="btn btn-outline-dark rounded rounded-pill w-100"><i class="fas fa-user-graduate"></i>
                        Students
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
    <hr class="p-0 mb-0">
    <div class="row mb-5" style="max-height: 90vh">
        <div class="col-12">
            <div class="h4 text-center mb-3 mt-3">
                Dashboard
            </div>
        </div>
        <div class="col-md-8">
            <div class="row p-1 align-items-end">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h5 class="p-0 m-0">Events/Announcements in College level</h5>
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
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#dpt"
                        type="button" role="tab" aria-controls="dpt" aria-selected="true">Departments</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#students"
                        type="button" role="tab" aria-controls="students" aria-selected="false">Students</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="dpt" role="tabpanel" aria-labelledby="dpt-tab">
                    <div class="row">
                        <div class="col-12">
                            <div class="row p-1 align-items-end">
                                <div class="col-12 d-flex justify-content-between align-items-center">
                                    <h5 class="p-0 m-0">Departments Here</h5>
                                    <span>
                                        <a href="department/create?cid=<?php echo $query_params['cid'] ?>"
                                            class="btn btn-outline-primary rounded rounded-pill btn-sm"
                                            class="btn btn-info strong">
                                            Create <i class="bi bi-plus-lg"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <ul class="list-group">
                                <?php foreach ($departments as $dept) {
echo "
                            <li class='list-group-item d-flex justify-content-between align-items-center'>
                                <a style='text-decoration:none'
                                        href='department?did={$dept['id']}&cid={$query_params['cid']}' class='strong'>
                                    <div class='h6 d-block text-truncate'>
                                        <i class='fas fa-building me-1'></i>
                                            {$dept['dpt_name']} • <small class='small text-muted'>{$dept['category']}</small>
                                    </div>
                                </a>
                            </li>
";
}?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="students" role="tabpanel" aria-labelledby="students-tab">
                    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/students/list.php';?>
                </div>
            </div>
        </div>
    </div>
</div>