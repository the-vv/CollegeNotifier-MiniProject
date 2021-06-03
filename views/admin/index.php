<?php

if (!isset($_COOKIE['adminUser'])) {
    header('Location:admin/login');
    // echo "<script type='text/javascript'>location.href = 'admin/login';</script>";
}
else {
    echo "logged in";
}
?>