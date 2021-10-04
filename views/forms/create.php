<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/form.php';
if (isset($query_params['fid'])) {
    $formdata = get_form($query_params['fid'])[0];
}
?>

<script src=" https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="/jsLibs/form-builder/form-builder.min.js"></script>

<div class="container-fluid bg-light mx-md-4 shadow rounded mb-4" id="departments" style="min-height: 85vh">
    <div class="row">
        <div class="col-12">
            <p class="h3 text-center"><?php if (isset($query_params['fid'])) { echo "Edit"; } else { echo "Create"; }?> a Form</p>
        </div>
        <?php if (isset($query_params['fid'])) { ?>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                    </symbol>
                </svg>
                <div class="alert mb-1 alert-warning alert-dismissible fade show d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-3" width="24" height="24" role="img" aria-label="Warning:">
                        <use xlink:href="#exclamation-triangle-fill" />
                    </svg>
                    <div class="">
                        Warning: New edits will not affect already submitted forms!
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php }?>
        <div class="col-12">
            <form id="builder" action="forms/submit?<?php echo $url_with_query_params ?>" method="POST">
                <div class="row">
                    <div class="col-12">
                        <label for="title"> Form Title *</label>
                        <input type="text" name="title" id="formTitleControl" class="form-control mb-3"
                            placeholder="Type something" required
                            value="<?php if (isset($formdata)) { echo $formdata['title']; }?>">
                    </div>
                </div>
                <input type="hidden" name="referer" value="<?php echo ($_SERVER['HTTP_REFERER'] ?? 'college') ?>">
                <input type="hidden" name="formContent" id="formContent">
            </form>
            <div class="row" id="formError">
                <div class="col-12 mt-2 text-center">
                    <P class="text-center text-danger">Please add some form controls before submiting</P>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center mt-3">
                    <button type="submit" class="btn btn-primary px-4" id="submitButton">
                        <?php if (isset($query_params['fid'])) { echo "Update Form"; } else { echo "Submit Form"; }?>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-5">
        <div class="col-12">
            <div class="formeo-wrap"></div>
        </div>
    </div>
</div>
<script>
$('#formError').hide()
if ($('#formTitleControl').val().length) {
    $('#submitButton').attr('disabled', false);
} else {
    $('#submitButton').attr('disabled', true)
}
$('#formTitleControl').on('input', () => {
    if ($('#formTitleControl').val().length > 0) {
        $('#submitButton').attr('disabled', false);
    } else {
        $('#submitButton').attr('disabled', true)
    }
})

let options = {
    showActionButtons: false,
    defaultFields: <?php if (isset($formdata)) { echo $formdata['content']; } else { echo "[]"; }?>
};
let builder = $(document.getElementById('builder')).formBuilder(options);
$('#submitButton').click((e) => {
    let form = JSON.parse(builder.formData)
    // console.log(form)
    if (form && Array.isArray(form) && form.length) {
        $('#formError').hide()
        $("#formContent").val(builder.formData);
        document.getElementById('builder').submit()
    } else {
        $('#formError').show()
    }
});
</script>