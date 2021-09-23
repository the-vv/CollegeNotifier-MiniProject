<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/department.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/batch.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/event.php';

$did = $query_params['did'] ?? 0;
$bid = $query_params['bid'] ?? 0;
$cid = $query_params['cid'] ?? 0;

if ($did == 0) {
    echo json_encode(array('error' => true, 'message' => "DID not provided"));
} else if ($cid == 0) {
    echo json_encode(array('error' => true, 'message' => "CID not provided"));
} else if ($bid == 0) {
    echo json_encode(array('error' => true, 'message' => "BID not provided"));
} else {
    $batch = get_batch($bid);
    $classes = array();
    $classes = get_classes($did, $cid, $bid);
    foreach ($classes as $class) {
        array_push($classes, $class);
    }
    $events = get_events_by_batch($cid, $did, $bid);
    $students = get_students_from_batch($bid);
    $class_ids = array_map(function ($class) {
        return $class['id'];
    }, $classes);
    $event_ids = array_map(function ($event) {
        return $event['id'];
    }, $events);
    $student_ids = array_map(function ($student) {
        return $student['id'];
    }, $students);

    $event_res = delete_event_multiple($event_ids);
    $class_res = delete_class_multiple($class_ids);
    $students_res = map_students($student_ids, $cid, $did);
    if (isset($event_res['success']) && isset($class_res['success']) && isset($students_res['success'])) {
        $res = delete_batch($bid);
        echo json_encode($res);
    } else {
        echo json_encode(
            array(
                'error' => true,
                "result" => array(
                    "event" => $event_res,
                    "class" => $class_res,
                    "students" => $students_res
                )
            )
        );
    }
}
