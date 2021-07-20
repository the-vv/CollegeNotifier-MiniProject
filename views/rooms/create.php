<?php
$cid = 0;
if (isset($query_params['cid'])) {
    $cid = $query_params['cid'];
} else {
    $error_mess = 'College Id not provided';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}
?>
<div class="container shadow border rounded rounded-lg">
    <div class="row">
        <div class="col-12 p-5">
            <h2 class="text-center"> Create Room now </h2>
            <form class="mt-4" action="rooms/submit?cid=<?php echo $cid ?>" method="POST">
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="name">Room Name*</label>
                    <input type="text" class="form-control" name="name" id="name" required
                        aria-describedby="nameHelp" placeholder="Room name">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="exampleInputEmail1">Room Description</label>
                    <textarea type="text" class="form-control" name="description" id="exampleInputcategory1"
                        aria-describedby="categoryHelp" placeholder="Room Description" maxlength="500" style="min-height:100px"></textarea>
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5" name="create">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>