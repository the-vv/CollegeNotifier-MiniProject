<?php
if (!isset($admin)) {
    $error_mess = 'Admin Data is required';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}
?>
<div class="">
    <div class="row">
        <div class="col-12 pb-5">
            <form class="" action="admin/submit" method="POST" id="form">
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="">Full Name</label>
                    <input type="text" class="form-control" name="name" required placeholder="Full Name" value="<?php echo $admin['name'] ?>">
                </div>
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="">Email address</label>
                    <input type="email" class="form-control" name="email" required aria-describedby="emailHelp"
                        placeholder="Email" value="<?php echo $admin['email'] ?>" readonly>
                </div>
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="">Mobile</label>
                    <input type="number" class="form-control" name="phone" required aria-describedby="emailHelp"
                        placeholder="10 digit Mobile number" value="<?php echo $admin['phone'] ?>">
                </div>
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="">New Password</label>
                    <input type="password" class="form-control" name="password" id="password"
                        placeholder="Leave blank to keep old password">
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5" name="update" id="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// document.getElementById('form').oninput = function() {
//     var password = document.getElementById('password');
//     var cpassword = document.getElementById('cpassword');
//     if (cpassword.value && cpassword.value != password.value) {
//         document.getElementById('submit').disabled = true;
//         document.getElementById('perror').style.display = 'inline';
//     } else {
//         document.getElementById('submit').disabled = false;
//         document.getElementById('perror').style.display = 'none';
//     }
// }
</script>