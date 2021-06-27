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

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>


<div class="container-fluid bg-light shadow border rounded rounded-lg mx-3">
    <div class="row">
        <div class="col-12 p-5">
            <h2 class="text-center"> Create an Event/Notification now </h2>
            <form class="mt-4 row" action="events/submit?<?php echo $url_with_query_params ?>" method="POST"
                enctype="multipart/form-data">
                <div class="mb-4 col-12">
                    <label for="formFile" class="form-label">Add attatchement if any</label>
                    <input class="form-control" type="file" id="formFile" name="attatchement">
                </div>
                <div class="col-12 mb-xl-4 mb-5" style="min-height:100px">
                    <div id="textEditor" style="min-height:100px"></div>
                </div>
                <input type="hidden" name="content">
                <div class="text-center mt-5">
                    <button type="button" class="btn btn-primary px-5" name="create">Publish</button>
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

    ['clean', 'image', 'video'] // remove formatting button
];

var quill = new Quill('#textEditor', {
    placeholder: 'Compose a Notification...',
    modules: {
        toolbar: toolbarOptions
    },
    theme: 'snow'
});
</script>