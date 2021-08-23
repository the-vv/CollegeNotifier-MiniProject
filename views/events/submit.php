<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/event.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
$user = get_current_logged_user();

$cid = $query_params['cid'] ?? 0;
$did = $query_params['did'] ?? 0;
$bid = $query_params['bid'] ?? 0;
$clid = $query_params['clid'] ?? 0;
$rid = $query_params['rid'] ?? 0;

function upload_file()
{
  if (!isset($_FILES['attatchement']) || $_FILES['attatchement']['error'] == UPLOAD_ERR_NO_FILE) {
    return '';
  } else {
    $path = "uploads/";
    $path = $path . basename(microtime(true) . '-' . $_FILES['attatchement']['name']);
    if (move_uploaded_file($_FILES['attatchement']['tmp_name'], $path)) {
      $success_mess = "The file " .  basename($_FILES['attatchement']['name']) .
        " has been uploaded";
      require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_success.php';
    } else {
      $error_mess = "There was an error uploading the file, please try again!";
      require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
      die();
    }
    return $path;
  }
  return '';
}

if (isset($_POST['eventContent'])) {
  $title = $_POST['title'];
  $is_event = isset($_POST['isevent']) ? 1 : 0;
  $content = $_POST['eventContent'];
  $time = time();
  if (strlen($_POST['attatchement']) < 1) {
    $attatchement = upload_file();
  } else {
    $attatchement = $_POST['attatchement'];
  }
  $referer = $_POST['referer'];
  $sdate = 0;
  $edate = 0;
  if ($is_event) {
    $sdate = $_POST['sdate'];
    $edate = $_POST['edate'];
  }
  $result = array();
  if (isset($query_params['eid'])) {
    $res = update_event_by_id($query_params['eid'], $title, $content, $time, $user['id'], $attatchement, $is_event, $sdate, $edate);
  } else {
    $res = create_event($did, $cid, $bid, $clid, $title, $content, $time, $user['id'], $attatchement, $is_event, $sdate, $edate, $rid);
  }
  if (isset($res['error'])) {
    $error_mess = $res['message'];
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
  } else {
    $success_mess = $res['message'];
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_success.php';
  }
  echo "    
        <div class='row'>
            <div class='col-12 text-center'>
                <span>
                    <a class='btn btn-light shadow border px-5 py-1' href='$referer'>Continue</a>
                </span>
            </div>
        </div>
    ";
  die();
}
