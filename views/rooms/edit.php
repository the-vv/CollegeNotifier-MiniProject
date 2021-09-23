<?php
$cid = 0;
$rid = 0;
if (isset($query_params['cid'])) {
    $cid = $query_params['cid'];
} else {
    $error_mess = 'College Id not provided';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}
if (isset($query_params['rid'])) {
    $rid = $query_params['rid'];
} else {
    $error_mess = 'Room Id not provided';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/rooms.php';
$Room = new rooms();
$current_room = $Room->get_one($rid);
$current_room = $current_room[0] ?? null;
if (!$current_room) {
    $error_mess = 'Invalid  Room id';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}
?>
<div class="container shadow border rounded rounded-lg">
    <div class="row">
        <div class="col-12 p-5">
            <h2 class="text-center"> Edit Room now </h2>
            <form class="mt-4" action="rooms/submit?<?php echo $url_with_query_params ?>" method="POST">
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="name">Room Name*</label>
                    <input type="text" class="form-control" name="name" id="name" required aria-describedby="nameHelp"
                        placeholder="Room name" value="<?php echo $current_room['room_name']?>">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="exampleInputEmail1">Room Description</label>
                    <textarea type="text" class="form-control" name="description" id="exampleInputcategory1"
                        aria-describedby="categoryHelp" placeholder="Room Description" maxlength="500"
                        style="min-height:100px"><?php echo $current_room['description'] ?></textarea>
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER'] ?>">
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5" name="update">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>