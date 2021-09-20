<?php

$clid = 0;
$cid = 0;
if (isset($query_params['cid'])) {
    $cid = $query_params['cid'];
} else {
    $error_mess = 'Required Params are not provided';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}
if (isset($query_params['clid'])) {
    $clid = $query_params['clid'];
} else {
    $error_mess = 'Required Params are not provided';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/class.php';
$class = null;
if($clid) {
    $class = get_a_class($clid);
    if(isset($class[0])) {
        $class = $class[0];
    } else {
        $error_mess = 'Invalid Class ID';
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php'; 
        die();
    }
}
?>
<div class="container shadow border rounded rounded-lg">
    <div class="row">
        <div class="col-12 p-5">
            <h2 class="text-center"> Create Class now </h2>
            <form class="mt-4"
                action="class/submit?<?php echo $url_with_query_params ?>"
                method="POST">
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="name">Enter Division Name</label>
                    <input type="text" class="form-control" name="div" id="name" required aria-describedby="nameHelp"
                        placeholder="Division Name" value="<?php echo $class['division'] ?>">
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