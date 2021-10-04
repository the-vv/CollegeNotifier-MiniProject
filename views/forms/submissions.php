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
// print_r($submissions);
?>

<script src="/jsLibs/form-builder/form-render.min.js"></script>
<script src="/jsLibs/jquery-ui-accordian/jquery-ui.min.js"></script>
<div class="container-fluid bg-light mx-md-4 shadow rounded mb-4" id="departments" style="min-height: 85vh">
    <div class="row my-4">
        <div class="col-12">
            <p class="h3 text-center">Form Submissions of <?php echo $formdata['title'] ?> </p>
        </div>
        <div class="offset-md-2 col-8 mt-3">
            <div id="accordion-wraper-custom">
                <?php foreach ($submissions as $submission) { ?>
                    <div class="accordion" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="acc_id_<?php echo $submission['id'] ?>">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-<?php echo $submission['id'] ?>" aria-expanded="false" aria-controls="flush-<?php echo $submission['id'] ?>">
                                    <span class="fw-bold"><?php echo $submission['user']['name'] ?></span>&nbsp;|&nbsp;<small><?php echo $submission['user']['email'] ?></small>
                                </button>
                            </h2>
                            <div id="flush-<?php echo $submission['id'] ?>" class="accordion-collapse collapse" aria-labelledby="acc_id_<?php echo $submission['id'] ?>" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div id="render_wrap_<?php echo $submission['id'] ?>"></div>
                                    <script>
                                        $('#render_wrap_<?php echo $submission['id'] ?>').formRender({
                                            formData: '<?php echo $submission['user_data'] ?>'
                                        })
                                    </script>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
            </div>
        </div>
    </div>

    <script>
        $(".accordion-body :input").prop("readonly", true);
    </script>