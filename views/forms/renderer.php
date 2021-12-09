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
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
$user = get_current_logged_user();

$submission = get_submissions_by_user_and_formid($user['id'], $user['type'], $query_params['fid']);
if(count($submission)) {
    $submission = $submission[0];
}
$submitted = false;
if(isset($submission) && isset($submission['user_data'])) {
    $submitted = true;
}
// echo "<pre>";
// print_r($formdata);
// print_r($submission);
// echo "</pre>";

?>
<!-- <script src=" https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script> -->
<script src="/jsLibs/form-builder/form-render.min.js"></script>

<div class="container-fluid bg-light mx-md-4 shadow rounded mb-4" id="departments" style="min-height: 85vh">
    <div class="row">
        <div class="col-12">
            <p class="h3 text-center">Submit Form <?php echo $formdata['title'] ?> </p>
        </div>
        <div class="col-12 col-md-6 offset-md-3">
            <form id="render-container" action="forms/submit?<?php echo $url_with_query_params; if($submitted) { echo "&subid=" . $submission['id']; } ?>" method="POST">
                <div id="render_wrap"></div>
                <input type="hidden" name="referer" value="<?php echo ($_SERVER['HTTP_REFERER'] ?? 'college') ?>">
                <input type="hidden" name="submissionContent" id="formContent">
                <input type="hidden" name="title" id="titleControl" value="<?php echo $formdata['title'] ?>">
            </form>
            <div class="row" id="formError">
                <div class="col-12 mt-2 text-center">
                    <P class="text-center text-danger">Please fill all the required fields to submit</P>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center mt-3">
                    <button type="submit" class="btn btn-primary px-4" id="submitButton">
                        <?php if ($submitted) { echo "Update Form"; } else { echo "Submit Form"; }?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$('#formError').hide()

function checkValidity() {
    let valid = true;
    $('[required]').each(function() {
        if ($(this).is(':invalid') || !$(this).val())
            valid = false;
    })
    return valid;
}

let options = {
    formData: `<?php echo ($submission['user_data'] ?? ($formdata['content'] ?? '[]'))?>`
}
const formRender = $('#render_wrap').formRender(options);

$('#submitButton').click((e) => {
    // console.log(formRender.userData)
    let data = JSON.stringify(formRender.userData)
    // console.log(data)
    $('#formError').hide()
    $("#formContent").val(data);
    // console.log(checkValidity())
    if (checkValidity()) {
        // console.log($("#formContent").val())
        document.getElementById('render-container').submit()
    } else {
        $('#formError').show()
    }
});
</script>