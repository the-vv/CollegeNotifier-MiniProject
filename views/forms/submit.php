<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/form.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/form_submissions.php';

$user = get_current_logged_user();

$cid = $query_params['cid'] ?? 0;
$did = $query_params['did'] ?? 0;
$bid = $query_params['bid'] ?? 0;
$clid = $query_params['clid'] ?? 0;
$rid = $query_params['rid'] ?? 0;

if (isset($_POST['formContent'])) {
  $title = $_POST['title'];
  $content = $_POST['formContent'];
  $time = time();
  $referer = $_POST['referer'];
  $result = array();
  if (isset($query_params['fid'])) {
    $res = update_form_by_id($query_params['fid'], $title, $content, $time, $user['id'], $user['type']);
  } else {
    $res = create_form($did, $cid, $bid, $clid, $title, $content, $time, $user['id'], $user['type'], $rid);
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
if (isset($_POST['submissionContent'])) {
  if (!isset($query_params['fid'])) {
    $success_mess = "Required parameters not provided";
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_success.php';
    die();
  }
  $title = $_POST['title'];
  $content = $_POST['submissionContent'];
  $time = time();
  $referer = $_POST['referer'];
  $result = array();
  if (isset($query_params['subid'])) {
    $res = update_submission_by_id($query_params['subid'], $title, $content, $query_params['fid'], $user['id'], $user['type']);
  } else {
    $res = create_submission($title, $content, $query_params['fid'], $user['id'], $user['type']);
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
} else {
  echo "Bad Request";
  print_r($_POST);
}
