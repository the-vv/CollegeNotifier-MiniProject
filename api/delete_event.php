<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/event.php';

$eid = $query_params['eid'] ?? 0;

if($eid == 0) {
    echo json_encode(array('error' => true, 'message' => "EID not provided"));
}
else {
    $res = delete_event($eid);
    if($res['success']) {
        echo json_encode($res);
    }
    else {
        echo $res;
    }
}