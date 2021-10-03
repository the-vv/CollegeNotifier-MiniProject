<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/views/forms/all_forms.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/form_submissions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';

$user = get_current_logged_user();
?>
<div class="row p-1">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="p-0 m-0">
                Available Forms assigned to you
            </h5>
        </div>
    </div>
</div>
<ul class="list-group">
    <?php foreach ($allforms as $form) {
        $submission = get_submissions_by_user_and_formid($user['id'], $user['type'], $form['id']);
        if (count($submission)) {
            $submission = $submission[0];
        }
        $submitted = false;
        if (isset($submission) && isset($submission['user_data'])) {
            $submitted = true;
        }
        echo "
        <li class='list-group-item d-flex justify-content-between align-items-center'>
            <a href='forms/render?fid={$form['id']}&{$url_with_query_params}' style='text-decoration:none' class='strong stretched-link d-flex align-items-center'>
                <div class='h6 d-block text-truncate d-flex align-items-center'><i class='bi bi-input-cursor-text me-2' style='font-size:1.5em;'></i>{$form['title']}</div>
            </a>
            ";
            if($submission) {
                echo "<span title='Form is submitted'><i class='bi bi-check-circle-fill text-success' style='font-size: 1.5em'></i></span>";
            } 
            echo "
            </li>
            ";
    } ?>
</ul>