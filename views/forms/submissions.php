<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/form.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/form_submissions.php';
if (isset($query_params['fid'])) {
    $formdata = get_form($query_params['fid'])[0];
} else {
    $error_mess = "Form Id not provided";
    require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}
$submissions = get_submissions_by_formid($query_params['fid']);
print_r($submissions);
?>
