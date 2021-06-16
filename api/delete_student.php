<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/student.php';

$sid = isset($query_params['sid']) ? $query_params['sid'] : 0;

if($sid == 0) {
    echo json_encode(array('error' => true, 'message' => "SID not provided"));
}
else {
    $res = delete_student($sid);
    echo json_encode($res);
}