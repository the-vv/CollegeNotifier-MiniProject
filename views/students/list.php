<!-- Button trigger modal -->

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/students/create.php';?>
<ul class="list-group">
    <?php
    foreach ($students as $s) {
        echo "<li class='list-group-item d-inline-block text-truncate text-start d-flex align-items-center'>\n";
        echo "<span class='d-inline-block'><i class='fas fa-user-graduate h2 me-3 p-0 m-0'></i></span>\n";
        echo "<span class='d-inline-block'><strong>{$s['student_name']}</strong><br>\n";
        echo "<small class='small'>{$s['email']}</small></span>\n\n";
    }
    ?>
</ul>