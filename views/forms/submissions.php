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
<div class="container-fluid bg-light mx-md-4 shadow rounded mb-4" id="departments" style="min-height: 85vh">
    <div class="row my-4">
        <div class="col-12">
            <p class="h3 text-center">Form Submissions of <?php echo $formdata['title'] ?> </p>
        </div>
        <div class="offset-md-2 col-md-8 mt-3">
            <div class="accordion" id="accordionFlushExample">
                <?php foreach ($submissions as $submission) { ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="acc_id_<?php echo $submission['id'] ?>">
                        <button class="accordion-button collapsed d-flex justify-content-between" type="button"
                            data-bs-toggle="collapse" data-bs-target="#flush-<?php echo $submission['id'] ?>"
                            aria-expanded="false" aria-controls="flush-<?php echo $submission['id'] ?>">
                            <p class="m-0 p-0">
                                <span
                                    class="fw-bold"><?php echo $submission['user']['name'] ?></span>&nbsp;|&nbsp;<span class="fst-italic fw-light"><?php echo $submission['user']['email'] ?>
                                </span>
                            </P>
                            <p class="m-0 p-0 d-block mx-1">
                                (<span class="sub_time"><?php echo $submission['submission_time'] ?></span>)
                            </p>
                        </button>
                    </h2>
                    <div id="flush-<?php echo $submission['id'] ?>" class="accordion-collapse collapse"
                        aria-labelledby="acc_id_<?php echo $submission['id'] ?>"
                        data-bs-parent="#accordionFlushExample">
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
$(document).ready(() => {
    $("li.formbuilder-icon-file").hide()
});

$('.sub_time').each(function(index, element) {
    console.log($(this).html())
    let date = new Date($(this).html() * 1000).toLocaleTimeString("en-US", { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' })
    $(this).html(date)
})
</script>