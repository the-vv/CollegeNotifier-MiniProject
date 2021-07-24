<?php
if (!isset($_COOKIE['studentUser'])) {
    header('Location:student/login');
}
$sid = $query_params['sid'] ?? 0;
$student = array();
if ($sid) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/student.php';
    $stud = get_student($sid);
    if (count($stud) > 0) {
        $student = $stud[0];
    } else {
        $error_mess = 'Student Id Missmatch Error';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
} else {
    $error_mess = 'Student Id not Provided';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}

$cid = $student['college_id'] ?? 0;
$did = $student['dpt_id'] ?? 0;
$bid = $student['batch_id'] ?? 0;
$clid = $student['class_id'] ?? 0;

$college = array();
$department = array();
$batch = array();
$class = array();
$student = array();

if ($cid) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/college.php';
    $college = get_college($cid);
    if (count($college) > 0) {
        $college = $college[0];
    } else {
        $error_mess = 'College Missmatch Error';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
}
?>

<div class="container-fluid bg-light mx-md-4 pt-2 shadow rounded" id="rooms" style="min-height: 85vh">
    <ol class="breadcrumb" style="--bs-breadcrumb-divider: '>';">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="admin"><?php echo $college['college_name'] ?></a></li>
        <li class="breadcrumb-item"><a href="college?cid=<?php echo $query_params['cid'] ?>"><?php echo $current_room['room_name'] ?></a>
        </li>
        <li class="breadcrumb-item">Dashboard</li>
    </ol>
    <div class="row mb-5 mt-2">
        <div class="col-12">
            <div class="h4 text-center mb-3 mt-3">
                <?php echo $current_room['room_name'] ?> Dashboard
                <small class="d-block" style="font-size:0.98rem; font-weight: 400"><?php echo $current_room['description'] ?></small>
            </div>
        </div>
        <div class="col-md-8">
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/events/index.php' ?>
        </div>
        <div class="col-md-4">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="batch-tab" data-bs-toggle="tab" data-bs-target="#batch" type="button" role="tab" aria-controls="batch" aria-selected="true">Faculties</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="students-tab" data-bs-toggle="tab" data-bs-target="#students" type="button" role="tab" aria-controls="students" aria-selected="false">Students</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="batch" role="tabpanel" aria-labelledby="batch-tab">
                    <div class="row p-1 align-items-end">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <h5 class="p-0 m-0">Faculties Here</h5>
                            <span>
                                <a href="batch/create?<?php echo $url_with_query_params ?>" class="btn btn-outline-primary rounded rounded-pill btn-sm" class="btn btn-info strong">
                                    Create <i class="bi bi-plus-lg"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                    <ul class="list-group">
                        <!-- <?php foreach ($batches as $batch) {
                                    echo "
                        <li class='list-group-item d-flex justify-content-between align-items-center'>
                            <a href='batch?bid={$batch['id']}&{$url_with_query_params}' style='text-decoration:none' class='strong stretched-link'>
                                <div class='h6 d-block text-truncate'><i class='fas fa-graduation-cap me-1'></i>{$batch['start_year']} - {$batch['end_year']} Batch</div>
                            </a>
                        </li>
                        ";
                                } ?> -->
                    </ul>
                </div>
                <div class="tab-pane fade" id="students" role="tabpanel" aria-labelledby="students-tab">
                    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/students/list.php'; ?>
                </div>
            </div>
        </div>
    </div>
</div>