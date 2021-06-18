<div class="container border rounded shadow">
    <div class="row pt-5">
        <div class="col-12">
            <?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/department.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/college.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/batch.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/student.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
// $user = get_current_logged_user();
// $department = get_dpt($query_params['did'])[0];
// $college = get_college($query_params['cid'])[0];
// $batch = get_batch($query_params['bid'])[0];
// $current_class = get_a_class($query_params['clid'])[0];
// $students = get_students_from_class($current_class['id']);
$students = array();
if ($query_param_values['cid'] == 0) {
    $error_mess = "College Id not provided.";
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
} else {
    $students = get_students_from_college($query_param_values['cid']);
    echo "<pre>";
    print_r($students);
    echo "</pre>";
}
?>
            <?php if ($query_param_values['rid'] != 0) { ?>
            <h3 class="text-center">Students will be mapped to this Room</h3>
            <?php } elseif ($query_param_values['clid'] != 0) { ?>
            <h3 class="text-center">Students will be mapped to this Class</h3>
            <?php } elseif ($query_param_values['bid'] != 0) { ?>
            <h3 class="text-center">Students will be mapped to this Batch</h3>
            <?php } elseif ($query_param_values['did'] != 0) { ?>
            <h3 class="text-center">Students will be mapped to this Department</h3>
            <?php } else {
                $error_mess = "Required parameters not provided or mapping not allowed here.";
                require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
            } ?>
        </div>
    </div>
    <div class="row pb-5">
        <div class="col-5">
            <select name="from[]" id="search" class="form-control" size="8" multiple="multiple">
            <?php
            foreach ($students as $s) {?>
                <option value="<?php echo $s['id'] ?>" class="border p-2 my-1">
                <?php 
                echo "{$s['student_name']} - ";
                echo "{$s['email']}";
                ?>
                </option>
            <?php }?>
            </select>
        </div>
        <div class="col-2">
            <button type="button" id="search_rightAll" class="btn btn-outline-secondary w-100 mt-3 mb-3"><i
                    class="bi bi-chevron-double-right"></i></button>
            <button type="button" id="search_rightSelected" class="btn btn-outline-secondary w-100 mb-3"><i
                    class="bi bi-chevron-right"></i></button>
            <button type="button" id="search_leftSelected" class="btn btn-outline-secondary w-100 mb-3"><i
                    class="bi bi-chevron-left"></i></button>
            <button type="button" id="search_leftAll" class="btn btn-outline-secondary w-100 mb-3"><i
                    class="bi bi-chevron-double-left"></i></button>
        </div>
        <div class="col-5">
            <select name="to[]" id="search_to" class="form-control" size="8" multiple="multiple"></select>
        </div>
    </div>
</div>

<script type="text/javascript" src="/js-vendor/multiselect/multiselect.js"></script>
<script>
$(document).ready(function() {
    $('#search').multiselect({
        search: {
            left: '<input type="text" name="q" class="form-control mb-1" placeholder="Search..." />',
            right: '<input type="text" name="q" class="form-control mb-1" placeholder="Search..." />',
        },
        fireSearch: function(value) {
            return value.length > 0;
        }
    });
})
</script>