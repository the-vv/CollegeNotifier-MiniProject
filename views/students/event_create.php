<form id="eventForm" class="mt-1 row d-flex align-items-center justify-content-center" method="POST" enctype="multipart/form-data">
    <div class="form-group col-md-9 text-start">
        <label for="">Title of the Notification</label>
        <input type="text" class="form-control" name="title" id="title" aria-describedby="" placeholder="Enter Title"
            required>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Mode of this Nofitication</label>
        <div class="form-check form-switch">
            <input class="form-check-input " type="checkbox" value="event"
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
        <select class="form-select" id="create_under" aria-label="Default select example" name="for_where" required>
            <option selected value="">Select one</option>
            <?php if($college) { echo "<option value='cid={$college['id']}'>{$college['college_name']}</option>"; } ?>
            <?php if($department) { echo "\n<option value='cid={$college['id']}&did={$department['id']}'>{$department['dpt_name']} Department</option>"; } ?>
            <?php if($batch) { echo "\n<option value='cid={$college['id']}&did={$department['id']}&bid={$batch['id']}'>{$batch['start_year']} - {$batch['end_year']} Batch</option>"; } ?>
            <?php if($class) { echo "\n<option value='cid={$college['id']}&did={$department['id']}&bid={$batch['id']}&clid={$class['id']}'>Class {$class['division']}</option>"; } ?>
            <?php foreach($rooms as $room) { echo "\n<option value='cid={$college['id']}&rid={$room['id']}'>Room: {$room['room_name']}</option>"; }?>
        </select>
    </div>
    <div class="col-12 mb-xl-4 mb-5" style="min-height:100px">
        <div id="textEditor" class="bg-light" style="min-height:100px"></div>
    </div>
    <input type="hidden" name="referer"
        value="<?php echo "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}" ?>">
    <input type="hidden" name="attatchement" id="attatchement" value="">
    <input type="hidden" name="eventContent" id="eventContent">
    <div class="text-center mt-2">
        <button type="submit" class="btn btn-primary px-5" name="publish" id="publishEvent">Publish</button>
    </div>
</form>
<script type="text/javascript">
'use strict';

let fileRemoved = false;
let modeSwitcher = () => {
    if (document.getElementById('isEventSwitch').checked) {
        $('#dateselection input').prop('required', true);
        $('#dateselection').show(200);
    } else {
        $('#dateselection input').prop('required', false);
        $('#dateselection').hide(200)
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

var quill = new Quill('#eventForm #textEditor', {
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
    $("#eventContent").val(quill.root.innerHTML);
    $('#eventForm').attr('action', `events/submit?${$('#create_under').val()}`);
    document.getElementById("eventForm").submit();
    $("#publishEvent").attr("disabled", true);
    $("#publishEvent").text('Publishing...')
})
</script>