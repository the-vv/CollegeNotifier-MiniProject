<?php
setcookie(CookieNames::admin, '', time()-3600, '/');
unset($_COOKIE[CookieNames::admin]);
setcookie(CookieNames::student, '', time()-3600, '/');
unset($_COOKIE[CookieNames::student]);
header('Location:/');
// echo "<script>location.href='/'</script>";