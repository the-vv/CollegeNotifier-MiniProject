<?php

$cid = isset($query_params['cid']) ? $query_params['cid'] : 0;
$did = isset($query_params['did']) ? $query_params['did'] : 0;
$bid = isset($query_params['bid']) ? $query_params['bid'] : 0;
$clid = isset($query_params['clid']) ? $query_params['clid'] : 0;

require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/student.php';

function import_students_from_file($fname)
{
    global $query_params, $target_file;
    require_once $_SERVER['DOCUMENT_ROOT'] . '\libs\spreadsheet-reader-master\php-excel-reader\excel_reader2.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '\libs\spreadsheet-reader-master\SpreadsheetReader.php';

    $Reader = new SpreadsheetReader($_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $fname);
    $students = array();
    $header = 0;
    foreach ($Reader as $Row) {
        if ($header == 0) {
            $header = 1;
            continue;
        }
        array_push($students, array('name' => $Row[0], 'email' => $Row[1], 'phone' => $Row['phone']));
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

if (isset($query_params['multiple']) && $query_params['multiple'] == '1') {
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
    if ($_FILES["students"]["size"] > 500000) {
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
}
else {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $phone = isset($_POST['phone']) ? $_POST['phone'] : 0;
    $res = create_student($did, $cid, $bid, $clid, 0, 0, $name, $email);
    if (isset($res['error'])) {
        $error_mess = $res['message'];
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    } else {
        $success_mess = $res['message'];
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_success.php';
    }
}
?>
<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <span>
                <a class="btn btn-outline-primary shadow border px-5 py-1" href="<?php echo $_SERVER['HTTP_REFERER'] ?>">Continue</a>
            </span>
        </div>
    </div>
</div>