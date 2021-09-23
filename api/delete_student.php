<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/student.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/room_student_map.php';

$sid = isset($query_params['sid']) ? $query_params['sid'] : 0;

if($sid == 0) {
    echo json_encode(array('error' => true, 'message' => "SID not provided"));
}
else {
    $Mapper = new RoomStudentMap();
    $mapper_res = $Mapper->remove_one_by_student($sid);
    if(isset($mapper_res['success']))
    {
        $res = delete_student($sid);
        echo json_encode($res);
    } else {
        echo json_encode(
            array(
                'error' => true,
                "result" => array(
                    "mapper" => $mapper_res
                )
            )
        );
    }
}
