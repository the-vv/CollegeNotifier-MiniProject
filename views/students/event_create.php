<h2 class="text-center"> Create an Event/Notification now </h2>
<form id="eventForm" class="mt-4 row d-flex align-items-center" method="POST" enctype="multipart/form-data">
    <div class="form-group col-md-9 text-start">
        <label for="">Title of the Notification</label>
        <input type="text" class="form-control" name="title" id="title" aria-describedby="" placeholder="Enter Title"
            required>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Mode of this Nofitication</label>
        <div class="form-checkr">
            <input class="form-check-input " style="border-radius: 5px;" type="checkbox" value="event"
                id="isEventSwitch" name="isevent">
            <label class="form-check-label " for="isEventSwitch">This is an Event</label>
        </div>
    </div>
    <div id="dateselection" class="col-12 mb-3">
        <div class="row">
            <div class="col-6">
                <label for="formFile" class="form-label">Set Starting Date</label>
                <input class="form-control" type="datetime-local" id="sdate" name="sdate">
            </div>
            <div class="col-6">
                <label for="formFile" class="form-label">Set Ending date</label>
                <input class="form-control" type="datetime-local" id="edate" name="edate">
            </div>
        </div>
    </div>
    <div class="mb-4 col-6">
        <label for="formFile" class="form-label">Add attatchement if any</label>
        <input class="form-control" type="file" id="formFile" name="attatchement" onchange="removeFile()">
    </div>
    <div class="mb-4 col-6">
        <label for="for_where" class="form-label">Create under</label>
        <select class="form-select" aria-label="Default select example" name="for_where" required>
            <option selected>Open this select menu</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
        </select>
    </div>
    <div class="col-12 mb-xl-4 mb-5" style="min-height:100px">
        <div id="textEditor" class="bg-light" style="min-height:100px"></div>
    </div>
    <input type="hidden" name="referer"
        value="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/student' ?>">
    <input type="hidden" name="attatchement" id="attatchement" value="">
    <input type="hidden" name="eventContent" id="eventContent">
    <div class="text-center mt-5">
        <button type="submit" class="btn btn-primary px-5" name="publish" id="publishEvent">Publish</button>
    </div>
</form>
<script type="text/javascript">
'use strict';

let fileRemoved = false;
let modeSwitcher = () => {
    if (document.getElementById('isEventSwitch').checked) {
        $('#dateselection').show(200);
        $('#dateselection input').prop('required', true);
    } else {
        $('#dateselection').hide(200)
        $('#dateselection input').prop('required', false);
    }
}
$('document').ready(modeSwitcher)
$('#isEventSwitch').change(modeSwitcher);
let removeFile = () => {
    fileRemoved = true;
    $('#attatchement').val('');
    $("#hasFile").empty();
}
let toolbarOptions = [
    ['bold', 'italic', 'underline', 'strike'],
    ['blockquote', 'code-block'],
    [{
        'header': 1
    }, {
        'header': 2
    }],
    ['formula', 'clean', 'image', 'video'],
    [{
        'list': 'ordered'
    }, {
        'list': 'bullet'
    }],
    [{
        'script': 'sub'
    }, {
        'script': 'super'
    }],
    [{
        'indent': '-1'
    }, {
        'indent': '+1'
    }],
    [{
        'direction': 'rtl'
    }],
    [{
        'size': ['small', false, 'large', 'huge']
    }],
    [{
        'header': [1, 2, 3, 4, 5, 6, false]
    }],
    [{
        'color': []
    }, {
        'background': []
    }],
    [{
        'font': []
    }],
    [{
        'align': []
    }]
];

var quill = new Quill('#textEditor', {
    placeholder: 'Compose an Event/Notification...',
    modules: {
        imageResize: {
            displaySize: true,
        },
        toolbar: toolbarOptions
    },
    theme: 'snow'
});
$("#eventForm").submit((e) => {
    e.preventDefault();
    console.log(quill.root.innerHTML);
    $("#eventContent").val(quill.root.innerHTML);
    document.getElementById("eventForm").submit();
})
</script>