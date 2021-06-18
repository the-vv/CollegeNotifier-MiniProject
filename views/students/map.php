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
        <div class="col-12">
            <select id="countries" class="multiselect" multiple="multiple" name="countries[]">
                <option value="AFG">Afghanistan</option>
                <option value="ALB">Albania</option>
                <option value="DZA">Algeria</option>
                <option value="AND">Andorra</option>
                <option value="ARG">Argentina</option>
                <option value="ARM">Armenia</option>
                <option value="ABW">Aruba</option>
                <option value="AUS">Australia</option>
                <option value="AUT" selected="selected">Austria</option>
            </select>
        </div>
    </div>
</div>
