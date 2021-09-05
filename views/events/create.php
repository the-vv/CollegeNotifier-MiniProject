<?php
$cid = 0;
$event = null;
if (isset($query_params['eid'])) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/db/event.php';
    $event = get_event($query_params['eid']);
    $event = $event[0] ?? null;
    if($event == null) {
        $error_mess = 'Incorrect Event ID';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
} elseif (isset($query_params['cid'])) {
    $cid = $query_params['cid'];
} else {
    $error_mess = 'Required Parameters not provided';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}
?>


<div class="container-fluid px-md-5 bg-light shadow rounded rounded-lg mx-3">
    <div class="row px-md-5">
        <div class="col-12 p-md-5">
            <h2 class="text-center"> Create an Event/Notification now </h2>
            <form id="eventForm" class="mt-4 row d-flex align-items-center"
                action="events/submit<?php if(isset($query_params['eid'])){ echo "?eid=" . $query_params['eid']; } else { echo "?" . $url_with_query_params; }?>" method="POST" enctype="multipart/form-data">
                <div class="form-group col-md-9 text-start">
                    <label for="">Title of the Notification</label>
                    <input type="text" class="form-control" name="title" id="title" aria-describedby=""
                        <?php if($event) { echo "value='{$event['title']}'"; } ?> placeholder="Enter Title" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Mode of this Nofitication</label>
                    <div class="fform-check form-switch">
                        <input class="form-check-input " type="checkbox" value="event"
                        <?php if($event && isset($event['is_event']) && $event['is_event'] == 1) { echo "checked"; } ?> id="isEventSwitch" name="isevent">
                        <label class="form-check-label " for="isEventSwitch">This is an Event</label>
                    </div>
                </div>
                <div id="dateselection" class="col-12 mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label for="formFile" class="form-label">Set Starting Date</label>
                            <input class="form-control" type="datetime-local" id="sdate" name="sdate"
                            <?php if($event) { echo "value='{$event['starttime']}'"; } ?> >
                        </div>
                        <div class="col-6">
                            <label for="formFile" class="form-label">Set Ending date</label>
                            <input class="form-control" type="datetime-local" id="edate" name="edate"
                            <?php if($event) { echo "value='{$event['endtime']}'"; } ?> >
                        </div>
                    </div>
                </div>
                <div class="mb-4 col-12">
                    <label for="formFile" class="form-label">Add attatchement if any</label>
                    <input class="form-control" type="file" id="formFile" name="attatchement" onchange="removeFile()">
                    <?php if($event && strlen($event['attatchement'])) { ?>
                        <div class="d-flex justify-items-between" id="hasFile">
                            <div for="formFile d-inline-block text-truncate"><strong>File Selected:</strong> <?php echo explode('/',$event['attatchement'])[1] ?></div>
                            <button class="btn btn-link btn-sm" onclick="removeFile()" type="button">Remove</button>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-12 mb-xl-4 mb-5" style="min-height:100px">
                    <div id="textEditor" class="bg-light" style="min-height:100px"></div>
                </div>
                <input type="hidden" name="referer"
                    value="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/admin' ?>">
                <input type="hidden" name="attatchement" id="attatchement" value="">
                <input type="hidden" name="eventContent" id="eventContent">
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-primary px-5" name="publish" id="publishEvent">Publish</button>
                </div>
            </form> 
        </div>
    </div>
</div>
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
<?php if($event && strlen($event['content'])) { echo "quill.root.innerHTML=`{$event['content']}`;\n"; } ?>
$("#eventForm").submit((e) => {
    e.preventDefault();
    console.log(quill.root.innerHTML);
    $("#eventContent").val(quill.root.innerHTML);
    if(<?php if($event && strlen($event['attatchement'])) { echo 1; } else { echo 0; }?> && !fileRemoved) {
        $('#attatchement').val('<?php if($event && strlen($event['attatchement'])){ echo $event['attatchement']; } ?>')
    }
    document.getElementById("eventForm").submit();
    $("#publishEvent").attr("disabled", true);
    $("#publishEvent").text('Publishing...')
})
</script>