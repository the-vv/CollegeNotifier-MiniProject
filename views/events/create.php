<?php
$cid = 0;
$event = null;
if (isset($query_params['eid'])) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/event.php';
    $event = get_event($query_params['eid']);
    $event = $event[0] ?? null;
    if($event == null) {
        $error_mess = 'Incorrect Event ID';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
    print_r($event);
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
                action="events/submit?<?php echo $url_with_query_params ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group col-md-9 text-start">
                    <label for="">Title of the Notification</label>
                    <input type="text" class="form-control" name="title" id="title" aria-describedby=""
                        <?php if($event) { echo "value='{$event['title']}'"; } ?> placeholder="Enter Title" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Mode of this Nofitication</label>
                    <div class="form-checkr">
                        <input class="form-check-input " style="border-radius: 5px;" type="checkbox" value=""
                        <?php if($event && isset($event['is_event'])) { echo "checked='{$event['is_event']}'"; } ?> id="isEventSwitch" name="isevent">
                        <label class="form-check-label " for="isEventSwitch">Mark this as an Event</label>
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
                    <input class="form-control" type="file" id="formFile" name="attatchement">
                    <?php if($event && strlen($event['attatchement'])) { ?>
                        <div class="d-flex justify-items-between">
                            <label for="formFile"><strong>File Seleced:</strong> <?php echo explode('/',$event['attatchement'])[1] ?></label>
                            <button class="btn btn-link btn-sm" type="button">Remove</button>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-12 mb-xl-4 mb-5" style="min-height:100px">
                    <div id="textEditor" class="bg-light" style="min-height:100px"></div>
                </div>
                <input type="hidden" name="referer"
                    value="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/admin' ?>">
                <input type="hidden" name="eventContent" id="eventContent">
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-primary px-5" name="publish" id="publishEvent">Publish</button>
                </div>
            </form> 
            <!-- TODO: editing this is to be handled -->
        </div>
    </div>
</div>
<script type="text/javascript">
let modeSwitcher = () => {
    if (document.getElementById('isEventSwitch').checked) {
        $('#dateselection').show();
        $('#dateselection input').prop('required', true);
    } else {
        $('#dateselection').hide()
        $('#dateselection input').prop('required', false);
    }
}
$('document').ready(modeSwitcher)
$('#isEventSwitch').change(modeSwitcher);

var toolbarOptions = [
    ['bold', 'italic', 'underline', 'strike'],
    ['blockquote', 'code-block'],
    [{
        'header': 1
    }, {
        'header': 2
    }],
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
    }],
    ['formula', 'clean', 'image', 'video'] 
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
<?php if($event && strlen($event['content'])) { echo "quill.root.innerHTML='{$event['title']}';\n"; } ?>
$("#eventForm").submit((e) => {
    e.preventDefault();
    console.log(quill.root.innerHTML);
    $("#eventContent").val(quill.root.innerHTML);
    document.getElementById("eventForm").submit();
})
</script>