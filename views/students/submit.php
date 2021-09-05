<?php

$cid = $query_params['cid'] ?? 0;
$did = $query_params['did'] ?? 0;
$bid = $query_params['bid'] ?? 0;
$clid = $query_params['clid'] ?? 0;
$rid = $query_params['rid'] ?? 0;

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/student.php';

function import_students_from_file($fname)
{
    global $target_file, $cid, $did, $bid, $clid;
    require_once $_SERVER['DOCUMENT_ROOT'] . '\libs\spreadsheet-reader-master\php-excel-reader\excel_reader2.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '\libs\spreadsheet-reader-master\SpreadsheetReader.php';

    $Reader = new SpreadsheetReader($_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $fname);
    $students = array();
    $header = 0;
    try {
        foreach ($Reader as $Row) {
            if ($header == 0) {
                $header = 1;
                continue;
            }
            array_push($students, array('name' => $Row[0], 'email' => $Row[1], 'phone' => $Row['2'], 'gender' => $Row['3']));
        }
    } catch (Exception $e) {
        $error_mess = "Error Occured while processing Students from Excell sheet\n<br> $e";
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
    $res = create_multiple_students($students, $did, $cid, $bid, $clid);
    if (isset($res['error'])) {
        $error_mess = $res['message'];
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    } else {
        $success_mess = $res['message'];
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_success.php';
    }
    unlink($target_file);
}

if (isset($_POST['login'])) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/clear_cookie.php';
    $email = $_POST['email'];
    $lpassword = $_POST['password'];
    require_once $_SERVER['DOCUMENT_ROOT'] . '/db/student.php';
    $user = find_student_by_email($email);
    if (isset($user['error'])) {
        $error_mess = $user['message'];
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    } elseif (count($user) > 0) {
        if (password_verify($lpassword, $user[0]['student_password'])) {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/hashing.php';
            $token = encrypt($user[0]['email']);
            setcookie(CookieNames::student, $token, time() + (86400 * 30), '/');
            header("Location:/student");
            // echo "<script>location.href='../admin'</script>";
        } else {
            $error_mess = 'Incorrect Credentials';
            require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        }
    } else {
        $error_mess = 'Incorrect Credentials';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    }
} elseif (isset($_POST['mapings'])) {
    // print_r($_POST);
    $mappings = json_decode($_POST['mapings']);
    $referer = $_POST['referer'];
    // print_r($mappings);
    $res = map_students($mappings, $cid, $did, $bid, $clid);
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
} elseif (isset($_POST['room_mapings'])) {
    // print_r($_POST);
    require $_SERVER['DOCUMENT_ROOT'] . '/db/room_student_map.php';
    $Mapper = new RoomStudentMap();
    $mappings = json_decode($_POST['room_mapings']);
    $referer = $_POST['referer'];
    // print_r($mappings);
    // die();
    foreach ($mappings as $mapping) {
        $res = $Mapper->insert_one($cid, $rid, $mapping);
        // print_r($res);
        if (isset($res['error'])) {
            $error_mess = $res['message'];
            require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
            die();
        }
    }
    // $res = map_students($mappings, $cid, $did, $bid, $clid);
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
} elseif (isset($_POST['edit'])) {
    $sid = $_POST['id'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $phone = isset($_POST['phone']) ? $_POST['phone'] : 0;
    $gender = $_POST['gender'];
    $password = isset($_POST['password']) ? $_POST['password'] : 0;
    $referer = $_POST['referer'];
    $res = update_student_by_id($sid, $name, $email, $phone, $gender, $password);
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
} elseif (isset($query_params['multiple']) && $query_params['multiple'] == '1') {
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/";
    $target_file = $target_dir . basename($_FILES["students"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (!isset($query_params['cid'])) {
        $error_mess = "College Id not provided.";
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["students"]["size"] > 10000000) {
        $error_mess = "Sorry, your file is too large";
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($fileType != "xlsx" && $fileType != "xls" && $fileType != "csv") {
        $error_mess = "Sorry, XLSX/ XLS/ CSV are supported";
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $error_mess = "Sorry, your file was not uploaded.";
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["students"]["tmp_name"], $target_file)) {
            $success_mess = "The file " . htmlspecialchars(basename($_FILES["students"]["name"])) . " has been uploaded.";
            require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_success.php';
            @import_students_from_file(basename($_FILES["students"]["name"]));
        } else {
            $error_mess = "Sorry, there was an error uploading your file.";
            require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        }
    }
} else {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/clear_cookie.php';
    $email = $_POST['email'];
    $name = $_POST['name'];
    $phone = isset($_POST['phone']) ? $_POST['phone'] : 0;
    $gender = $_POST['gender'];
    $res = create_student($did, $cid, $bid, $clid, 0, 0, $name, $email, $phone, $gender);
    if (isset($res['error'])) {
        $error_mess = $res['message'];
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    } else {
        $success_mess = $res['message'];
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_success.php';
    }
}
?>
<div class="row">
    <div class="col-12 text-center mt-2">
        <span>
            <a class="btn btn-light shadow border px-5 py-1" href="<?php echo $_SERVER['HTTP_REFERER'] ?>">Continue</a>
        </span>
    </div>
</div>