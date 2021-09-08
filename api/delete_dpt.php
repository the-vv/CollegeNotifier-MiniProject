<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/department.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/batch.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/event.php';

$did = $query_params['did'] ?? 0;
$cid = $query_params['cid'] ?? 0;

if ($did == 0) {
    echo json_encode(array('error' => true, 'message' => "DID not provided"));
} else if ($cid == 0) {
    echo json_encode(array('error' => true, 'message' => "CID not provided"));
} else {
    $batches = get_batches($cid, $did);
    $classes = array();
    foreach ($batches as $batch) {
        $classes = get_classes($did, $cid, $batch['id']);
        foreach ($classes as $class) {
            array_push($classes, $class);
        }
    }
    $events = get_events_by_dpt($cid, $did);
    $students = get_students_from_dpt($did);

    $batch_ids = array_map(function ($batch) {
        return $batch['id'];
    }, $batches);
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
    $batch_res = delete_batch_multiple($batch_ids);
    $class_res = delete_class_multiple($class_ids);
    $students_res = map_students($student_ids, $cid);
    if (isset($event_res['success']) && isset($batch_res['success']) && isset($class_res['success']) && isset($students_res['success'])) {
        $res = delete_dpt($did);
        echo json_encode($res);
    } else {
        json_encode(array(
            'error' => true,
            "result" => array(
                "event" => $event_res, "batch" => $batch_res, "class" => $class_res, "students" => $students_res
            )
        ));
    }
}
