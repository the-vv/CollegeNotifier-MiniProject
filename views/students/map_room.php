<div class="container-fluid bg-light mx-md-4 shadow rounded" id="departments" style="min-height: 85vh">
    <div class="row pt-5">
        <div class="col-12">
            <?php
            require_once $_SERVER['DOCUMENT_ROOT'] . '/db/room_student_map.php';
            $students_all = array();
            if ($query_param_values['cid'] == 0) {
                $error_mess = "College Id not provided.";
                require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
            } else {
                $room_to_add = '';
                if ($query_param_values['rid'] != 0 && $query_param_values['cid'] != 0) {
                    $room_to_add = 'room_id';
                    $StudentMapper = new RoomStudentMap();
                    $students_all = $StudentMapper->get_students_to_map($query_param_values['cid'], $query_param_values['rid']);
                    // print_r($students_all);
                } 
                else {
                    $error_mess = "Required parameters not provided or mapping not allowed here.";
                    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
                    die();
                }
            }
            ?>
            <?php if ($query_param_values['rid'] != 0) { ?>
                <h3 class="text-center">Students will be mapped to this Room</h3>
            <?php } ?>
            <p class="small p-0 m-0 text-muted text-center">Use ctrl/shift key to select multiple students at once</p>
        </div>
    </div>
    <div class="row mt-4 d-flex justify-content-evenly">
        <div class="col-10 col-sm-5 mb-2">
            <p class="h6">Available students to map</p>
            <select name="from[]" id="search" style="height:350px" class="form-control" size="8" multiple="multiple">
                <?php
                foreach ($students_all as $s) { ?>
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

<script type="text/javascript" src="/jsLibs/multiselect/multiselect.js"></script>
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
        field.attr("name", 'room_mapings');
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
