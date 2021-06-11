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
    <div class="row mt-4 text-center">
        <h2>
            Welcome, <?php echo $user['admin_name'] ?>
        </h2>
        <h6>
            <?php echo $user['email'] ?>
        </h6>
    </div>
    <div class="d-flex justify-content-center border pt-2 rounded col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="admin"><?php echo $college['college_name'] ?></a></li>
                <li class="breadcrumb-item"><a href="#">Departments</a></li>
            </ol>
        </nav>
    </div>
    <div class="row mb-5" style="max-height: 90vh">
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
                <div class="col-12">
                    <div class="h4 text-center mb-4 mt-3">
                        Departments managed by you
                    </div>
                    <ul class="list-group">
                        <?php foreach ($departments as $dept) {
                        echo "
                            <li class='list-group-item d-flex justify-content-between align-items-center'>
                                <a style='text-decoration:none' href='department?did={$dept['id']}&cid={$query_params['cid']}' class='strong'>
                                    <div class='h6 d-block text-truncate'><i class='fas fa-building me-1'></i>{$dept['dpt_name']} • <small class='small text-muted'>{$dept['category']}</small></div>
                                </a>
                            </li>
                            ";
                        }?>
                        <li
                            class="list-group-item d-flex justify-content-between align-items-center bg-secondary text-white">
                            <span class="h5">Create one:</span>
                            <a href="department/create?cid=<?php echo $query_params['cid'] ?>"
                                class="btn btn-info strong">
                                Create
                            </a>
                        </li>
                    </ul>
                </div>
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
</div>