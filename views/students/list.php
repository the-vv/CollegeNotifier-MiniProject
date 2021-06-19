
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/students/create.php';?>
<div id="students-list-container">
    <ul class="list-group" id="StudentsList">
        <?php
    foreach ($students as $s) {
        echo "<li class='list-group-item d-inline-block text-truncate text-start d-flex align-items-center'>\n";
        echo "<span class='d-inline-block'><i class='fas fa-user-graduate h2 me-3 p-0 m-0'></i></span>\n";
        echo "<span class='d-inline-block'><strong>{$s['student_name']}</strong><br>\n";
        echo "<small class='small'>{$s['email']}</small></span>\n\n";
    }
    ?>
    </ul>
</div>

<script type='text/javascript'>
$(function() {
    $("#StudentsList").JPaging();
});
</script>

