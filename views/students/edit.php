<?php
if (!isset($cid)) {
    $cid = isset($query_params['cid']) ? $query_params['cid'] : 0;
}
if (!isset($sid)) {
    $sid = isset($query_params['sid']) ? $query_params['sid'] : 0;
}
if($sid == 0) {
    $error_mess = 'Student ID not provided';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}
if($cid == 0) {
    $error_mess = 'College ID not provided';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/student.php';
if (!isset($student)) {
    $student_details = get_student($sid)[0];
} else {
    $student_details = $student;
}
if (!isset($student)) {
    ?>
<div class="container-fluid bg-light mx-md-4 shadow rounded border" id="departments" style="min-height: 85vh">
    <?php
} ?>
    <div class="row <?php if(!isset($student)) { echo "pt-5"; } else { echo "pb-5 pt-3"; }?>">
        <div class="col-12">
        <?php if(!isset($student)) { ?><p class="h3 text-center mb-3">Edit student</p><?php }?>
            <form class="row px-md-5 align-items-end" action="students/submit?<?php echo $url_with_query_params ?>"
                method="POST" id="singleForm">
                <div class="form-group col-12 col-md-6 offset-md-3 text-start">
                    <label for="exampleInputEmail1">Full Name*</label>
                    <input type="text" class="form-control" name="name" id="sname" required
                        aria-describedby="categoryHelp" placeholder="Enter Name"
                        value="<?php echo $student_details['name'] ?>">
                </div>
                <div class="form-group col-12 col-md-6 offset-md-3 text-start mt-3">
                    <label for="exampleInputEmail1">Phone</label>
                    <input type="text" class="form-control" name="phone" id="snumber" aria-describedby="categoryHelp"
                        placeholder="Enter phone"
                        value="<?php echo isset($student_details['phone']) ? $student_details['phone'] : null; ?>">
                </div>
                <div class="form-group col-12 col-md-6 offset-md-3 text-start  mt-3">
                    <label for="name">Email Id*</label>
                    <input type="text" class="form-control" name="email" id="semail" required
                        aria-describedby="nameHelp" placeholder="Create Email"
                        value="<?php echo $student_details['email'] ?>">
                </div>
                <div class="form-group col-12 col-md-6 offset-md-3 text-start  mt-3">
                    <label for="name">Select Gender*</label>
                    <select class="form-select" aria-label="Default select example" name="gender" id="gender" required>
                        <option value="">Gender</option>
                        <option <?php echo $student_details['gender'] == 'male' ? 'selected' : '' ?> value="male">Male
                        </option>
                        <option <?php echo $student_details['gender'] == 'female' ? 'selected' : '' ?> value="female">
                            Female</option>
                    </select>
                </div>
                <div class="form-group col-12 col-md-6 offset-md-3 text-start d-none">
                    <label for="exampleInputEmail1">Student ID</label>
                    <input type="number" class="form-control" name="id" id="id" placeholder="ID" readonly
                        value="<?php echo $student_details['id']?>">
                </div>
                <div class="form-group col-12 col-md-6 offset-md-3 text-start  mt-3">
                    <label for="name">New Password</label>
                    <input type="password" class="form-control" name="password" id="password"
                        aria-describedby="nameHelp" placeholder="Leave blank to keep old password">
                </div>
                <input type="hidden" name="referer"
                    value="<?php if (!isset($student)) { echo (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/admin'); } else { echo "/my-profile"; } ?>">
                <div class="form-group col-12 text-center mt-5">
                    <input type="submit" class="btn btn-primary px-5" name="edit" id="edit" value="Save Changes">
                </div>
            </form>
        </div>
    </div>
    <?php if(!isset($student)) { ?>
</div>
<?php }?>