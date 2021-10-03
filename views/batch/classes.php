<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/department.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/college.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/batch.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/student.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
$user = get_current_logged_user();
$department = get_dpt($query_params['did'])[0];
$college = get_college($query_params['cid'])[0];
$batch = get_batch($query_params['bid'])[0];
$classes = get_classes($department['id'], $college['id'], $batch['id']);
$students = get_students_from_batch($batch['id'])
?>

<div class="container-fluid bg-light mx-md-4 shadow rounded border" id="departments" style="min-height: 85vh">
    <ol class="breadcrumb" style="--bs-breadcrumb-divider: '>';">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="admin"><?php echo $college['college_name'] ?></a></li>
        <li class="breadcrumb-item"><a
                href="college?cid=<?php echo$query_params['cid'] ?>"><?php echo $department['dpt_name'] ?></a>
        </li>
        <li class="breadcrumb-item"><a
                href="department?did=<?php echo$query_params['did'] ?>&cid=<?php echo$query_params['cid'] ?>"><?php echo "{$batch['start_year']} - {$batch['end_year']} Batch" ?></a>
        </li>
        <li class="breadcrumb-item">Classes</li>
    </ol>
    <?php if ($user['type'] == 'admin') {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/admininstration/index.php';
    }?>
    <div class="row mb-5" style="max-height: 90vh">
        <div class="col-12">
            <div class="h4 text-center mb-3 mt-3">
                <?php echo "{$batch['start_year']} - {$batch['end_year']} Batch" ?> Dashboard
            </div>
        </div>
        <div class="col-md-8">
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/events/index.php'?>
        </div>
        <div class="col-md-4">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="class-tab" data-bs-toggle="tab" data-bs-target="#class"
                        type="button" role="tab" aria-controls="class" aria-selected="true">Classes</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="students-tab" data-bs-toggle="tab" data-bs-target="#students"
                        type="button" role="tab" aria-controls="students" aria-selected="false">Students</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#forms"
                        type="button" role="tab" aria-controls="forms" aria-selected="false">Forms</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="class" role="tabpanel" aria-labelledby="class-tab">
                    <div class="row p-1">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <h5 class="p-0 m-0">Classes Here</h5>
                            <span>
                                <a href="class/create?cid=<?php echo $query_params['cid'] ?>&did=<?php echo $query_params['did'] ?>&bid=<?php echo $query_params['bid'] ?>"
                                    class="btn btn-outline-primary rounded rounded-pill btn-sm">
                                    Create <i class="bi bi-plus-lg"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                    <ul class="list-group">
                        <?php foreach ($classes as $class) {
                        echo "
                        <li class='list-group-item d-flex justify-content-between align-items-center'>
                            <a href='class?clid={$class['id']}&bid={$query_params['bid']}&cid={$query_params['cid']}&did={$query_params['did']}' style='text-decoration: none' class='strong stretched-link'>
                                <div class='h6 d-block text-truncate'><i class='fas fa-chalkboard-teacher me-1'></i> Class: {$class['division']} division</div>
                            </a>
                        </li>
                        ";
                    } ?>
                    </ul>
                </div>
                <div class="tab-pane fade" id="students" role="tabpanel" aria-labelledby="students-tab">
                    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/students/list.php';?>
                </div>
                <div class="tab-pane fade" id="forms" role="tabpanel" aria-labelledby="forms-tab">
                    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/forms/index.php'; ?>
                </div>
            </div>
        </div>
    </div>
</div>