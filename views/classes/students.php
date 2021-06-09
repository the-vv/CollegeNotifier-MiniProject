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
$current_class = get_a_class($query_params['id'])[0];
$students = get_students_from_class($current_class['id'])
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
                <li class="breadcrumb-item"><a href="college?id=<?php echo$query_params['cid'] ?>"><?php echo $department['dpt_name'] ?></a></li>
                <li class="breadcrumb-item"><a href="department?id=<?php echo$query_params['did'] ?>&cid=<?php echo$query_params['cid'] ?>"><?php echo "{$batch['start_year']} - {$batch['end_year']} Batch" ?></a></li>
                <li class="breadcrumb-item"><a href="batch?id=<?php echo$query_params['bid'] ?>&did=<?php echo$query_params['did'] ?>&cid=<?php echo$query_params['cid'] ?>">Division <?php echo $class['division'] ?></a></li>
                <li class="breadcrumb-item"><a href="#">Students</a></li>
            </ol>
        </nav>
    </div>
    <div class="row mb-5">
        <div class="h4 text-center mb-4 mt-3">
        Students in this class
        </div>
        <ul class="list-group px-5">
            <?php foreach ($students as $stud) {
                echo "
                <li class='list-group-item d-flex justify-content-between align-items-center'>
                    <div class='h6 d-block text-truncate'>{$stud['student_name']} • {$stud['email']}</div>
                    <a href='college?id={$stud['id']}' class='btn btn-success px-md-5 strong'>
                        Go
                    </a>
                </li>
                ";
            } ?>
            <li class="list-group-item d-flex justify-content-evenly align-items-center bg-secondary text-white">
                <span class="h5">Add a student:</span>
                <a href="class/add" class="btn btn-info px-md-5 strong">
                    Add
                </a>
            </li>
        </ul>
    </div>
</div>
