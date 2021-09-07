<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/department.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/batch.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/event.php';

$did = $query_params['did'] ?? 0;
$cid = $query_params['cid'] ?? 0;

if ($did == 0) {
    echo json_encode(array('error' => true, 'message' => "DID not provided"));
}
if ($cid == 0) {
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

    $batch_ids = array_map(function ($batch) {
        return $batch['id'];
    }, $batches);
    $class_ids = array_map(function ($class) {
        return $class['id'];
    }, $classes);
    $event_ids = array_map(function ($event) {
        return $event['id'];
    }, $events);
    // TODO implement remaining delete funcitonality


    // $res = delete_dpt($did);
}