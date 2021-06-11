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
$current_class = get_a_class($query_params['clid'])[0];
$students = get_students_from_class($current_class['id']);
// print_r($students);
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
                <li class="breadcrumb-item"><a
                        href="college?cid=<?php echo$query_params['cid'] ?>"><?php echo $department['dpt_name'] ?></a>
                </li>
                <li class="breadcrumb-item"><a
                        href="department?did=<?php echo$query_params['did'] ?>&cid=<?php echo$query_params['cid'] ?>"><?php echo "{$batch['start_year']} - {$batch['end_year']} Batch" ?></a>
                </li>
                <li class="breadcrumb-item"><a
                        href="batch?bid=<?php echo$query_params['bid'] ?>&did=<?php echo$query_params['did'] ?>&cid=<?php echo$query_params['cid'] ?>">Division
                        <?php echo $class['division'] ?></a></li>
                <li class="breadcrumb-item"><a href="#">Students</a></li>
            </ol>
        </nav>
    </div>
    <div class="row mb-5">
        <div class="col-md-8">
            <div class="h4 text-center mb-4 mt-3">
                <?php echo $college['college_name'] ?> Dashboard
            </div>
            <div class="row p-1 align-items-end">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h6 class="p-0 m-0">Events/Announcements in Class level</h6>
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
            <div class="h4 text-center mb-4 mt-3">
                Students in this class
            </div>
            <div class="row p-1 align-items-end">
                <div class="col-12 d-flex justify-content-end align-items-center">
                    <span class="">
                        <button type="button" class="btn btn-outline-primary btn-sm rounded rounded-pill"
                            data-bs-target="">
                            Add new <i class="bi bi-person-plus-fill" style="font-size:.9rem"></i>
                        </button>
                    </span>
                    <span class="ps-2">
                        <button type="button" class="btn btn-outline-primary btn-sm rounded rounded-pill"
                            data-bs-toggle="modal" data-bs-target="#modelMultiple">
                            Create <i class="bi bi-plus-lg"></i>
                        </button>
                    </span>
                </div>
            </div>
            <ul class="list-group">
                <?php
                    foreach ($students as $s) {
                        echo "<li class='list-group-item d-inline-block text-truncate text-start d-flex align-items-center'>\n";
                        echo "<span class='d-inline-block'><i class='bi bi-person me-3' style='font-size:2rem'></i></span>\n";
                        echo "<span class='d-inline-block text-truncate'><strong>{$s['student_name']}</strong><br>\n";
                        echo "<small class='small'>{$s['email']}</small></span>\n\n";
                    }
                ?>
            </ul>
            <div class="col-6 text-center">
                <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/students/create.php';?>
            </div>
            <script type="text/javascript">
            document.getElementById('studentAdd').style.display = 'none';
            </script>
        </div>
    </div>
</div>