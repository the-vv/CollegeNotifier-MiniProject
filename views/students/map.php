<div class="container-fluid bg-light mx-md-4 shadow rounded" id="departments" style="min-height: 85vh">
    <div class="row pt-5">
        <div class="col-12">
            <?php

            require_once $_SERVER['DOCUMENT_ROOT'] . '/db/department.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/db/college.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/db/batch.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/db/class.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/db/student.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
            // $user = get_current_logged_user();
            // $department = get_dpt($query_params['did'])[0];
            // $college = get_college($query_params['cid'])[0];
            // $batch = get_batch($query_params['bid'])[0];
            // $current_class = get_a_class($query_params['clid'])[0];
            // $students = get_students_from_class($current_class['id']);
            $students_all = array();
            if ($query_param_values['cid'] == 0) {
                $error_mess = "College Id not provided.";
                require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
            } else {
                $students_all = get_students_from_college($query_param_values['cid']);
                $room_to_add = '';
                if ($query_param_values['clid'] != 0) {
                    $room_to_add = 'class_id';
                } elseif ($query_param_values['bid'] != 0) {
                    $room_to_add = 'batch_id';
                } elseif ($query_param_values['did'] != 0) {
                    $room_to_add = 'dpt_id';
                }
                else {
                    $error_mess = "Required parameters not provided or mapping not allowed here.";
                    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
                    die();
                }
                // TODO: implement parent room match checking
                // $students = $students_all;
                $students = array_filter($students_all, function ($stud) {
                    global $room_to_add;
                    if($stud[$room_to_add] != 0) {
                        return false;
                    }
                    return true;
                });
            }
            ?>
            <?php if ($query_param_values['rid'] != 0) { ?>
                <h3 class="text-center">Students will be mapped to this Room</h3>
            <?php } elseif ($query_param_values['clid'] != 0) {
                $current_class = get_a_class($query_params['clid'])[0] ?>
                <h3 class="text-center">Students will be mapped to the <?php echo $current_class['division'] ?> Division</h3>
            <?php } elseif ($query_param_values['bid'] != 0) {
                $batch = get_batch($query_params['bid'])[0] ?>
                <h3 class="text-center">Students will be mapped to the <?php echo $batch['start_year'] . '-' . $batch['end_year'] ?> Batch</h3>
            <?php } elseif ($query_param_values['did'] != 0) {
                $department = get_dpt($query_params['did'])[0] ?>
                <h3 class="text-center">Students will be mapped to the <?php echo $department['dpt_name'] ?> Department</h3>
            <?php } else {
                $error_mess = "Required parameters not provided or mapping not allowed here.";
                require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
            } ?>
            <p class="small p-0 m-0 text-muted text-center">Use ctrl/shift key to select multiple students at once</p>
        </div>
    </div>
    <div class="row mt-4 d-flex justify-content-evenly">
        <div class="col-10 col-sm-5 mb-2">
            <p class="h6">Available students to map</p>
            <select name="from[]" id="search" style="height:350px" class="form-control" size="8" multiple="multiple">
                <?php
                foreach ($students as $s) { ?>
                    <option value="<?php echo $s['id'] ?>" class="border p-2 my-1 rounded d-block text-truncate">
                        <?php
                        echo "{$s['name']} - ";
                        echo "{$s['email']}";
                        ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="col-1 d-flex align-items-center justify-content-center">
            <div class="text-md-center d-flex flex-column" id="mapControllers">
                <button title="Add All" type="button" id="search_rightAll" class=" btn btn-danger py-2 rounded-circle mb-3"><i class="bi bi-chevron-double-right"></i></button>
                <button title="Add Selected" type="button" id="search_rightSelected" class=" btn btn-warning py-2 rounded-circle mb-3"><i class="bi bi-chevron-right"></i></button>
                <button title="Remove Selected" type="button" id="search_leftSelected" class=" btn btn-warning py-2 rounded-circle mb-3"><i class="bi bi-chevron-left"></i></button>
                <button title="Remove All" type="button" id="search_leftAll" class=" btn btn-danger py-2 rounded-circle "><i class="bi bi-chevron-double-left"></i></button>
            </div>
        </div>
        <div class="col-12 col-sm-5">
            <p class="h6">Students to be mapped</p>
            <select name="to[]" id="search_to" style="height:350px" class="form-control" size="8" multiple="multiple"></select>
        </div>
    </div>
    <div class="row mb-5 mt-4">
        <div class="col-12 text-center">
            <button class="btn btn-primary px-5" id="mapNow" onclick="postMappings()" disabled>Map Now</button>
        </div>
    </div>
</div>

<script type="text/javascript" src="/js-vendor/multiselect/multiselect.js"></script>
<script>
    let values = [];
    let checkMapping = () => {
        values = [];
        $("#search_to option").each(function() {
            values.push($(this).val());
        });
        if (values.length > 0) {
            $('#mapNow').attr("disabled", false)
        } else {
            $('#mapNow').attr("disabled", true)
        }
    }
    $(document).ready(function() {
        $('#search').multiselect({
            search: {
                left: '<input type="text" name="q" class="form-control mb-1" placeholder="Start typing to search..." />',
                right: '<input type="text" name="q" class="form-control mb-1" placeholder="Start typing to search..." />',
            },
            fireSearch: function(value) {
                return value.length > 0;
            },
            afterMoveToRight: checkMapping,
            afterMoveToLeft: checkMapping
        });
    })

    function postMappings(parameters) {
        var form = $('<form></form>');
        form.attr("method", "post");
        form.attr("action", 'students/submit?<?php echo $url_with_query_params ?>');
        var field = $('<input></input>');
        field.attr("type", "hidden");
        field.attr("name", 'mapings');
        field.attr("value", JSON.stringify(values));
        form.append(field);
        var referer = $('<input></input>');
        referer.attr("type", "hidden");
        referer.attr("name", 'referer');
        referer.attr("value", '<?php echo $_SERVER['HTTP_REFERER'] ?>');
        form.append(referer);
        $(document.body).append(form);
        form.submit();
    }
</script>