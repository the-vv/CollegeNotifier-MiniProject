<script src=" https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="/jsLibs/form-builder/form-builder.min.js"></script>

<div class="container-fluid bg-light mx-md-4 shadow rounded" id="departments" style="min-height: 85vh">
    <div class="row">
        <div class="col-12">
            <p class="h3 text-center">Create a Form</p>
        </div>
        <div class="col-12">
            <form id="builder" action="forms/submit?<?php echo $url_with_query_params ?>" method="POST">
                <div class="row">
                    <div class="col-12">
                        <label for="title" onchange="checkTitle()"> Form Title</label>
                        <input type="text" name="title" id="formTitleControl" class="form-control mb-3"
                            placeholder="Type something" required>
                    </div>
                </div>
                <input type="hidden" name="referer" value="<?php echo ($_SERVER['HTTP_REFERER'] ?? 'college') ?>">
                <input type="hidden" name="formContent" id="formContent">
            </form>
            <div class="row">
                <div class="col-12 text-center mt-3">
                    <button type="submit" class="btn btn-primary px-4" id="submitButton">Submit Form</button>
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
$('#submitButton').attr('disabled', true);
$('#formTitleControl').on('input', () => {
    console.log('event')
    if ($('#formTitleControl').val().length > 0) {
        $('#submitButton').attr('disabled', false);
    } else {
        $('#submitButton').attr('disabled', true)
    }
})

let options = {
    onSave: function(evt, formData) {
        $('.formeo-wrap').formRender({
            formData
        });
        // console.log(formData);
    },
    showActionButtons: false
};
let builder = $(document.getElementById('builder')).formBuilder(options);
$('#submitButton').click((e) => {
    console.log(builder.formData)
    $("#formContent").val(builder.formData);
    console.log( $("#formContent").val())
    document.getElementById('builder').submit()
});
</script>