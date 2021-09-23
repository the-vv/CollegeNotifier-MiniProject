<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/department.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/batch.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/event.php';

$did = $query_params['did'] ?? 0;
$bid = $query_params['bid'] ?? 0;
$cid = $query_params['cid'] ?? 0;
$clid = $query_params['clid'] ?? 0;

if ($did == 0) {
    echo json_encode(array('error' => true, 'message' => "DID not provided"));
} else if ($cid == 0) {
    echo json_encode(array('error' => true, 'message' => "CID not provided"));
} else if ($bid == 0) {
    echo json_encode(array('error' => true, 'message' => "BID not provided"));
} else if ($clid == 0) {
    echo json_encode(array('error' => true, 'message' => "CLID not provided"));
} else {
    $events = get_events_by_class($cid, $did, $bid, $clid);
    $students = get_students_from_class($clid);
    $event_ids = array_map(function ($event) {
        return $event['id'];
    }, $events);
    $student_ids = array_map(function ($student) {
        return $student['id'];
    }, $students);

    $event_res = delete_event_multiple($event_ids);
    $students_res = map_students($student_ids, $cid, $did, $bid);
    if (isset($event_res['success']) && isset($students_res['success'])) {
        $res = delete_class($clid);
        echo json_encode($res);
    } else {
        echo json_encode(
            array(
                'error' => true,
                "result" => array(
                    "event" => $event_res,
                    "students" => $students_res
                )
            )
        );
    }
}
