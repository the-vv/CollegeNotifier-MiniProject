<?php
setcookie('adminUser', '', time()-3600, '/');
unset($_COOKIE['adminUser']);
setcookie('studentUser', '', time()-3600, '/');
unset($_COOKIE['studentUser']);
header('Location:/');
// echo "<script>location.href='/'</script>";