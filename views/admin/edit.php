<?php
if (!isset($admin)) {
    $error_mess = 'Admin Data is required';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}
?>
<div class="container shadow border rounded rounded-lg">
    <div class="row">
        <div class="col-12 p-5">
            <h2 class="text-center"> Edit Admin</h2>
            <form class="mt-4" action="admin/submit" method="POST" id="form">
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="">Full Name</label>
                    <input type="text" class="form-control" name="name" required placeholder="Full Name">
                </div>
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="">Email address</label>
                    <input type="email" class="form-control" name="email" required aria-describedby="emailHelp"
                        placeholder="Email">
                </div>
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="">Mobile (Optional)</label>
                    <input type="number" class="form-control" name="phone" required aria-describedby="emailHelp"
                        placeholder="10 digit Mobile number">
                </div>
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required
                        placeholder="Password">
                </div>
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="">Confirm Password</label>
                    <input type="password" class="form-control" name="cpassword" id="cpassword" required
                        placeholder="Confirm Password">
                    <small id="perror" class="form-text text-danger" style="display: none;">Passwords are not
                        matching</small>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5" name="signup" id="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('form').oninput = function() {
    var password = document.getElementById('password');
    var cpassword = document.getElementById('cpassword');
    if (cpassword.value && cpassword.value != password.value) {
        document.getElementById('submit').disabled = true;
        document.getElementById('perror').style.display = 'inline';
    } else {
        document.getElementById('submit').disabled = false;
        document.getElementById('perror').style.display = 'none';
    }
}
</script>