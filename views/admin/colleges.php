<?php

require $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
$user = get_current_logged_user();
?>

<div class="container">
    <div class="row text-center">
        Welcome, <?php echo $user['admin_name'] ?>
    </div>
</div>