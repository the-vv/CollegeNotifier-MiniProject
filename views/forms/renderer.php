<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/form.php';
if (isset($query_params['fid'])) {
    $formdata = get_form($query_params['fid'])[0];
} else {
    $error_mess = "Form Id not provided";
    require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}
?>
// TODO: check if user submited form. fetch and render it then, implement submit action
<!-- <script src=" https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script> -->
<script src="/jsLibs/form-builder/form-render.min.js"></script>

<div class="container-fluid bg-light mx-md-4 shadow rounded mb-4" id="departments" style="min-height: 85vh">
    <div class="row">
        <div class="col-12">
            <p class="h3 text-center">Submit Form <?php echo $formdata['title'] ?> </p>
        </div>
        <div class="col-12 col-md-6 offset-md-3">
            <form id="render-container" action="forms/submit?<?php echo $url_with_query_params ?>" method="POST">
                <input type="hidden" name="referer" value="<?php echo ($_SERVER['HTTP_REFERER'] ?? 'college') ?>">
                <input type="hidden" name="submissionContent" id="formContent">
            </form>
            <div class="row">
                <div class="col-12 text-center mt-3">
                    <button type="submit" class="btn btn-primary px-4" id="submitButton">
                        <?php if (isset($query_params['fid'])) { echo "Update Form"; } else { echo "Submit Form"; }?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
let options = {
    formData: '<?php echo ($formdata['content'] ?? '[]')?>'
}
const formRender = $('#render-container').formRender(options);

$('#submitButton').click((e) => {
    console.log(formRender.userData)
    let data = JSON.stringify(formRender.userData)
    console.log(data)
    return;
    if (form && Array.isArray(form) && form.length) {
        $('#formError').hide()
        $("#formContent").val(formRender.formData);
        document.getElementById('renderer').submit()
    } else {
        $('#formError').show()
    }
});
</script>