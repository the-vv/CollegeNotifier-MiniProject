<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/department.php';

$department = array();
$cid = 0;
if (isset($query_params['cid'])) {
    $cid = $query_params['cid'];
} else {
    $error_mess = 'Required Parameters not provided';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}
if(isset($query_params['did'])) {
    $department = get_dpt($query_params['did']);
    if(isset($department[0])) {
        $department = $department[0];
    } else {
        $error_mess = "Provided Parameters 'did' not incorrect";
        require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
        die();
    }
} else {
    $error_mess = 'Required Parameters not provided';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}
?>
<div class="container shadow border rounded rounded-lg">
    <div class="row">
        <div class="col-12 p-5">
            <h2 class="text-center"> Edit Department </h2>
            <form class="mt-4" action="department/submit?did=<?php echo $department['id'] ?>" method="POST">
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="name">Department Name*</label>
                    <input type="text" class="form-control" name="name" id="name" required
                        aria-describedby="nameHelp" placeholder="Department name" value="<?php echo $department['dpt_name'] ?>">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="exampleInputEmail1">Department category</label>
                    <input type="text" class="form-control" name="category" id="exampleInputcategory1"
                        aria-describedby="categoryHelp" placeholder="Department Category" value="<?php echo $department['category'] ?>">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5" name="edit">Update</button>
                </div>
                <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER'] ?? 'admin'; ?>">
            </form>
        </div>
    </div>
</div>