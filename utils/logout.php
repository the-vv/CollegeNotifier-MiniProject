<?php
setcookie('adminUser', '', time()-3600, '/');
unset($_COOKIE['adminUser']);
header('Location:/');
// echo "<script>location.href='/'</script>";