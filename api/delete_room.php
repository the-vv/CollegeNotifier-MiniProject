<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/rooms.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/room_student_map.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/event.php';

$rid= $query_params['rid'] ?? 0;
$cid = $query_params['cid'] ?? 0;

if ($rid == 0) {
    echo json_encode(array('error' => true, 'message' => "RID not provided"));
} else if ($cid == 0) {
    echo json_encode(array('error' => true, 'message' => "CID not provided"));
} else {
    $events = get_events_by_room($cid, $rid);
    $event_ids = array_map(function ($event) {
        return $event['id'];
    }, $events);
    
    $Room = new Rooms();
    $Mapper = new RoomStudentMap();

    $student_res = $Mapper->remove_one_by_room($rid);
    $event_res = delete_event_multiple($event_ids);
    
    if (isset($event_res['success']) && isset($student_res['success'])) {
        $res = $Room->delete_one($rid);
        echo json_encode($res);
    } else {
        echo json_encode(
            array(
                'error' => true,
                "result" => array(
                    "event" => $event_res,
                    "students" => $student_res
                )
            )
        );
    }
}
