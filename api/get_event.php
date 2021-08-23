<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/event.php';
if(!isset($query_params['eid'])) {
    echo json_encode(array('error' => true, 'message' => "EID not provided"));
}
else {
    $eid = $query_params['eid'];
    $res = get_event($eid);
    echo json_encode($res);
}
?>