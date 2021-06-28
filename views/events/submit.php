<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/event.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
$user = get_current_logged_user();

$cid = $query_params['cid'] ?? 0;
$did = $query_params['did'] ?? 0;
$bid = $query_params['bid'] ?? 0;
$clid = $query_params['clid'] ?? 0;

function upload_file() {
    if(!empty($_FILES['attatchement']))
  {
    $path = $_SERVER['DOCUMENT_ROOT'] . "/uploads/";
    $path = $path . basename(microtime(true) . '-' . $_FILES['attatchement']['name']);
    if(move_uploaded_file($_FILES['attatchement']['tmp_name'], $path)) {
      echo "The file ".  basename( $_FILES['attatchement']['name']). 
      " has been uploaded";
    } else{
        echo "There was an error uploading the file, please try again!";
    }
    return $path;
  }
  return '';
}

if(isset($_POST['eventContent'])) {
    $title = $_POST['title'];
    $is_event = isset($_POST['isevent']) ? 1 : 0;
    $content = $_POST['eventContent'];
    $time = time();
    $attatchement = upload_file();
    $res = create_event($did, $cid, $bid, $clid, $title, $content, $time, $user['id'], $attatchement, $is_event);
    // if (isset($res['error'])) {
    //     $error_mess = $res['message'];
    //     require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    // } else {
    //     $success_mess = $res['message'];
    //     require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_success.php';
    // }
    // echo "    
    // <div class='container'>
    //     <div class='row'>
    //         <div class='col-12 text-center'>
    //             <span>
    //                 <a class='btn btn-outline-primary shadow border px-5 py-1' href='$referer'>Continue</a>
    //             </span>
    //         </div>
    //     </div>
    // </div>
    // ";
    die();
}