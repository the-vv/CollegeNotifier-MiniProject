<?php
$room_to_add = '';
if ($query_param_values['clid'] != 0) {
    $room_to_add = 'Class';
} elseif ($query_param_values['bid'] != 0) {
    $room_to_add = 'Batch';
} elseif ($query_param_values['did'] != 0) {
    $room_to_add = 'Department';
} elseif ($query_param_values['cid'] != 0) {
    $room_to_add = 'College';
}
if ($query_param_values['rid'] != 0) {
    $room_to_add = 'Room';
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/form.php';
if ($room_to_add == 'College') {
    $forms = get_forms_by_college($query_param_values['cid']);
} elseif ($room_to_add == 'Department') {
    $forms = get_forms_by_dpt($query_param_values['cid'], $query_param_values['did']);
} elseif ($room_to_add == 'Batch') {
    $forms = get_forms_by_batch($query_param_values['cid'], $query_param_values['did'], $query_param_values['bid']);
} elseif ($room_to_add == 'Class') {
    $forms = get_forms_by_class($query_param_values['cid'], $query_param_values['did'], $query_param_values['bid'], $query_param_values['clid']);
} else {
    $forms = get_forms_by_param($query_param_values['cid'], $query_param_values['did'], $query_param_values['bid'], $query_param_values['clid'], $query_param_values['rid']);
}
// echo "<pre>";
// print_r($forms);
// echo "</pre>";
?>


<div class="row p-1 align-items-end">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h5 class="p-0 m-0">Forms Here</h5>
        <span>
            <a href="forms/create?<?php echo $url_with_query_params ?>" class="btn btn-outline-primary rounded rounded-pill btn-sm" class="btn btn-info strong">
                Create <i class="bi bi-plus-lg"></i>
            </a>
        </span>
    </div>
</div>
<ul class="list-group">
    <?php foreach ($forms as $form) {
        echo "
        <li class='list-group-item d-flex justify-content-between align-items-center'>
            <a href='forms/create?fid={$form['id']}&{$url_with_query_params}' style='text-decoration:none' class='strong stretched-link d-flex align-items-center'>
                <div class='h6 d-block text-truncate d-flex align-items-center'><i class='bi bi-input-cursor-text me-2' style='font-size:1.5em;'></i>{$form['title']} Form</div>
            </a>
        </li>
        ";
    } ?>
</ul>