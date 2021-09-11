<?php
// room is already in $current_room
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/college.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/rooms.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/room_student_map.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
$user = get_current_logged_user();
$college = get_college($query_params['cid'])[0];
$RoomMapper = new RoomStudentMap();
$students = $RoomMapper->get_all_students_in_room($query_params['cid'], $query_params['rid']);
// var_dump($students);
?>


<div class="container-fluid bg-light mx-md-4 pt-2 shadow rounded" id="rooms" style="min-height: 85vh">
    <ol class="breadcrumb" style="--bs-breadcrumb-divider: '>';">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="admin"><?php echo $college['college_name'] ?></a></li>
        <li class="breadcrumb-item"><a
                href="college?cid=<?php echo $query_params['cid'] ?>"><?php echo $current_room['room_name'] ?></a>
        </li>
        <li class="breadcrumb-item">Dashboard</li>
    </ol>
    <?php if ($user['type'] == 'admin') {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/admininstration/index.php';
    } ?>
    <div class="row mb-5 mt-2">
        <div class="col-12">
            <div class="h4 text-center mb-3 mt-3">
                <?php echo $current_room['room_name'] ?> Dashboard
                <small class="d-block"
                    style="font-size:0.98rem; font-weight: 400"><?php echo $current_room['description'] ?></small>
            </div>
        </div>
        <div class="col-md-8">
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/events/index.php' ?>
        </div>
        <div class="col-md-4">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="batch-tab" data-bs-toggle="tab" data-bs-target="#batch"
                        type="button" role="tab" aria-controls="batch" aria-selected="true">Faculties</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="students-tab" data-bs-toggle="tab" data-bs-target="#students"
                        type="button" role="tab" aria-controls="students" aria-selected="false">Students</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="batch" role="tabpanel" aria-labelledby="batch-tab">
                    <div class="row p-1 align-items-end">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <h5 class="p-0 m-0">Faculties Here</h5>
                            <span>
                                <a href="batch/create?<?php echo $url_with_query_params ?>"
                                    class="btn btn-outline-primary rounded rounded-pill btn-sm"
                                    class="btn btn-info strong">
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