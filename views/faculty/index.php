<?php

if (!isset($_COOKIE['facultyUser'])) {
    header('Location:faculty/login');
    // echo "<script type='text/javascript'>location.href = 'admin/login';</script>";
}
else {
    echo "logged in";
}
?>