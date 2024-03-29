<?php
$cid = 0;
if (isset($query_params['cid'])) {
    $cid = $query_params['cid'];
} else{
    $error_mess = 'College ID not provided';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}
?>
<div class="container shadow border rounded rounded-lg">
    <div class="row">
        <div class="col-12 p-5">
            <h2 class="text-center"> Create Department now </h2>
            <form class="mt-4" action="department/submit?cid=<?php echo $cid ?>" method="POST">
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="name">Department Name*</label>
                    <input type="text" class="form-control" name="name" id="name" required
                        aria-describedby="nameHelp" placeholder="Department name">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="exampleInputEmail1">Department category</label>
                    <input type="text" class="form-control" name="category" id="exampleInputcategory1"
                        aria-describedby="categoryHelp" placeholder="Department Category">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5" name="create">Create</button>
                </div>
                <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER'] ?? 'admin'; ?>">
            </form>
        </div>
    </div>
</div>