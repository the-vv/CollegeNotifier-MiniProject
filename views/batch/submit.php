<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
$user = get_current_logged_user();

$cid = 0;
if (isset($query_params['cid'])) {
    $cid = $query_params['cid'];
} else {
    $error_mess = 'College Id is invalid please try again.';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/batch.php';
if (isset($_POST['create'])) {
    $did = 0;
    if (isset($query_params['did'])) {
        $did = $query_params['did'];
    } else {
        $error_mess = 'Department Id is invalid please try again.';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
    $smonth = $_POST['smonth'];
    $emonth = $_POST['emonth'];
    $syear = explode('-', $smonth)[0];
    $smonth = explode('-', $smonth)[1];
    $eyear = explode('-', $emonth)[0];
    $emonth = explode('-', $emonth)[1];
    $res = create_batch($did, $cid, $syear, $smonth, $eyear, $emonth);
    if (isset($res['success'])) {
        echo "
        <svg xmlns='http://www.w3.org/2000/svg' style='display: none;'>
        <symbol id='check-circle-fill' fill='currentColor' viewBox='0 0 16 16'>
            <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
        </symbol>
        </svg>
                <div class='row my-4 text-center'>
                    <div class='alert alert-success d-flex align-items-center' role='alert'>
                        <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#check-circle-fill'/></svg>
                    <div>
                        Batch created successfully
                    </div>
                </div>
                <span><a class='btn btn-light shadow border px-5 py-1' href='../department?did=$did&cid=$cid'>Continue</a></span>
            </div>
        ";
    } elseif (isset($res['error'])) {
        echo "
        <svg xmlns='http://www.w3.org/2000/svg' style='display: none;'>
        <symbol id='exclamation-triangle-fill' fill='currentColor' viewBox='0 0 16 16'>
            <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
        </symbol>
        </svg>
                <div class='row my-4 text-center'>
                    <div class='alert alert-danger d-flex align-items-center' role='alert'>
                        <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                    <div>
                        An error occured: {$res['message']}
                    </div>
                </div>
                <span><a class='btn btn-light shadow border px-5 py-1' href='../'>Continue</a></span>
            </div>
        ";
    }
}
if (isset($_POST['update'])) {
    $bid = 0;
    if (isset($query_params['bid'])) {
        $bid = $query_params['bid'];
    } else {
        $error_mess = 'Batch Id is invalid please try again.';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
    $smonth = $_POST['smonth'];
    $emonth = $_POST['emonth'];
    $syear = explode('-', $smonth)[0];
    $smonth = explode('-', $smonth)[1];
    $eyear = explode('-', $emonth)[0];
    $emonth = explode('-', $emonth)[1];
    $res = update_batch($bid, $syear, $smonth, $eyear, $emonth);
    $referer = $_POST['referer'] ?? '/colllege';
    if (isset($res['success'])) {
        echo "
        <svg xmlns='http://www.w3.org/2000/svg' style='display: none;'>
        <symbol id='check-circle-fill' fill='currentColor' viewBox='0 0 16 16'>
            <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
        </symbol>
        </svg>
                <div class='row my-4 text-center'>
                    <div class='alert alert-success d-flex align-items-center' role='alert'>
                        <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#check-circle-fill'/></svg>
                    <div>
                        Batch Updated successfully
                    </div>
                </div>
                <span><a class='btn btn-light shadow border px-5 py-1' href='$referer'>Continue</a></span>
            </div>
        ";
    } elseif (isset($res['error'])) {
        echo "
        <svg xmlns='http://www.w3.org/2000/svg' style='display: none;'>
        <symbol id='exclamation-triangle-fill' fill='currentColor' viewBox='0 0 16 16'>
            <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
        </symbol>
        </svg>
                <div class='row my-4 text-center'>
                    <div class='alert alert-danger d-flex align-items-center' role='alert'>
                        <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                    <div>
                        An error occured: {$res['message']}
                    </div>
                </div>
                <span><a class='btn btn-light shadow border px-5 py-1' href='$referer'>Continue</a></span>
            </div>
        ";
    }
}
