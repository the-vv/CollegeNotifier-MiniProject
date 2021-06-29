<?php
$cid = 0;
if (isset($query_params['cid'])) {
    $cid = $query_params['cid'];
} else {
    $error_mess = 'Required Parameters not provided';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}
?>


<div class="container-fluid bg-light shadow rounded rounded-lg mx-3">
    <div class="row">
        <div class="col-12 p-5">
            <h2 class="text-center"> Create an Event/Notification now </h2>
            <form id="eventForm" class="mt-4 row d-flex align-items-center"
                action="events/submit?<?php echo $url_with_query_params ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group col-md-9 text-start">
                    <label for="">Title of the Notification</label>
                    <input type="text" class="form-control" name="title" id="title" aria-describedby=""
                        placeholder="Enter Title" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Mode of this Nofitication</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="isevent">
                        <label class="form-check-label" for="flexSwitchCheckDefault">This is an Event</label>
                    </div>
                </div>
                <div class="mb-4 col-12">
                    <label for="formFile" class="form-label">Add attatchement if any</label>
                    <input class="form-control" type="file" id="formFile" name="attatchement">
                </div>
                <div class="col-12 mb-xl-4 mb-5" style="min-height:100px">
                    <div id="textEditor" class="bg-light" style="min-height:100px"></div>
                </div>
                <input type="hidden" name="referer" value="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/admin' ?>">
                <input type="hidden" name="eventContent" id="eventContent">
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-primary px-5" name="publish" id="publishEvent">Publish</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
var toolbarOptions = [
    ['bold', 'italic', 'underline', 'strike'], // toggled buttons
    ['blockquote', 'code-block'],

    [{
        'header': 1
    }, {
        'header': 2
    }], // custom button values
    [{
        'list': 'ordered'
    }, {
        'list': 'bullet'
    }],
    [{
        'script': 'sub'
    }, {
        'script': 'super'
    }], // superscript/subscript
    [{
        'indent': '-1'
    }, {
        'indent': '+1'
    }], // outdent/indent
    [{
        'direction': 'rtl'
    }], // text direction

    [{
        'size': ['small', false, 'large', 'huge']
    }], // custom dropdown
    [{
        'header': [1, 2, 3, 4, 5, 6, false]
    }],

    [{
        'color': []
    }, {
        'background': []
    }], // dropdown with defaults from theme
    [{
        'font': []
    }],
    [{
        'align': []
    }],

    ['formula', 'clean', 'image', 'video'] // remove formatting button
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