<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/event.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/student.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/room_student_map.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/http.php';

$user = get_current_logged_user();

$cid = $query_params['cid'] ?? 0;
$did = $query_params['did'] ?? 0;
$bid = $query_params['bid'] ?? 0;
$clid = $query_params['clid'] ?? 0;
$rid = $query_params['rid'] ?? 0;

function production_mode_mailer($body)
{
  if (isset($body['to']) && !is_array($body['to'])) {
    $to      = $body['to'] ?? 'vvtec.dev@gmail.com';
    $subject = $body['subject'] ?? 'Mail subject Empty';
    $message = $body['body'] ?? 'Mail body Empty';

    $headers = "From: vvtec.dev@gmail.com" . "\r\n";
    $headers .= 'Reply-To: vvtec.dev@gmail.com' . "\r\n";
    $headers .= "CC: " . ($body['admin'] ?? 'vvtec.dev@gmail.com') . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $result = mail($to, $subject, $message, $headers);
    if ($result) {
      echo json_encode(array('success' => true, 'message' => 'Email has been sent successfully'));
    } else {
      echo json_encode(array('success' => false, 'message' => 'Error sending emails'));
    }
  } elseif (isset($body['to']) && is_array($body['to'])) {
    $recipients = array();
    foreach ($body['to'] as $send_to) {
      array_push($recipients, $send_to);
    }
    $to = implode(',', $recipients);
    $subject = $body['subject'] ?? 'Mail subject Empty';
    $message = $body['body'] ?? 'Mail body Empty';

    $headers = "From: vvtec.dev@gmail.com" . "\r\n";
    $headers .= 'Reply-To: vvtec.dev@gmail.com' . "\r\n";
    $headers .= "CC: " . ($body['admin'] ?? 'vvtec.dev@gmail.com') . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $result = mail($to, $subject, $message, $headers);
    if ($result) {
      return array('success' => true, 'message' => 'Email has been sent successfully');
    } else {
      return array('success' => false, 'message' => 'Error sending emails');
    }
  }
}

function send_email($event_title, $user, $event_type)
{
  global $rid, $cid, $clid, $bid, $did, $cid;
  if ($rid) {
    $mapper = new RoomStudentMap();
    $students = $mapper->get_all_students_in_room($cid, $rid);
  } elseif ($clid) {
    $students = get_students_from_class($clid);
  } elseif ($bid) {
    $students = get_students_from_batch($bid);
  } elseif ($did) {
    $students = get_students_from_dpt($did);
  } elseif ($cid) {
    $students = get_students_from_college($cid);
  }
  $to_mails = array_map(function ($item) {
    return $item['email'];
  }, $students);
  $body = array(
    "mail" => true,
    "subject" => "New " . ($event_type ? 'Event ' : 'Notification ') . "has been published, College Notifier",
    "to" => $to_mails,
    "body" => "<h1>New " . ($event_type ? 'Event ' : 'Notification ') . "Titled \"" . $event_title . "\" has been published by " . $user['type'] . " " . $user['name'] . "</h1><h2><a href='http://localhost:3000/student'>Click here to view</a></h2>"
  );
  if(FeatureConfigurations::production_mode) {
    $res = production_mode_mailer($body);
  } else {
    $result = httpPost("http://localhost/mailer/", $body);
    $res = json_decode($result);
    if (is_object($res)) {
      $res = get_object_vars($res);
    }
  }
  if (!isset($res['success'])) {
    $error_mess = "Error Sending Email";
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    return;
  }
  if ($res['success']) {
    $success_mess = $res['message'];
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_success.php';
  } else {
    $error_mess = $res['message'];
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
  }
}

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
  if (isset($_POST['isevent'])) {
    $is_event = 1;
  } else {
    $is_event = 0;
  }
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
  $create = false;
  if (isset($query_params['eid'])) {
    $res = update_event_by_id($query_params['eid'], $title, $content, $time, $user['id'], $user['type'], $attatchement, $is_event, $sdate, $edate);
  } else {
    $create = true;
    $res = create_event($did, $cid, $bid, $clid, $title, $content, $time, $user['id'], $user['type'], $attatchement, $is_event, $sdate, $edate, $rid);
  }
  if (isset($res['error'])) {
    $error_mess = $res['message'];
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
  } else {
    $success_mess = $res['message'];
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_success.php';
    if ($create && FeatureConfigurations::send_event_create_emails) {
      send_email($title, $user, $is_event);
    }
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
