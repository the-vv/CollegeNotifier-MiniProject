<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
$user = get_current_logged_user();

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
$user = get_current_logged_user();
// print_r($user);

require_once $_SERVER['DOCUMENT_ROOT'] . '/views/forms/all_forms.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/form_submissions.php';
if ($show_counters) {
    $unsubmitted_count = 0;
    foreach ($allforms as $form) {
        $tmp_submission = get_submissions_by_user_and_formid($user['id'], $user['type'], $form['id']);
        if (count($tmp_submission)) {
            $tmp_submission = $tmp_submission[0];
        }
        $submitted = false;
        if (isset($tmp_submission) && isset($tmp_submission['user_data'])) {
            $submitted = true;
        }
        if (!$submitted) {
            $unsubmitted_count++;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta property="og:title" content="College Notifier">
    <meta property="og:image" content="/public/assets/icon.png">
    <meta property="og:description" content="Cipher Chat, a protoype of college events and notifications management system">
    <meta property="og:url" content="https://collegenotifier.000webhostapp.com">
    <meta name="twitter:card" content="Tired of managing multiple WhatsApp groups? You are in the right place">
    <link rel="icon" href="/public/assets/icon.webp">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/">
    <title>College Notifier</title>

    <!-- Global CSS  -->
    <link rel="stylesheet" href="public/styles/style.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- Fonr-Awsome Icons  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- JQuery js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- JQuery Toasts plugin  -->
    <link rel="stylesheet" href="/jsLibs/jquery-toast-plugin-master/dist/jquery.toast.min.css">

    <!-- JQuery Dialog Plugin -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    <!-- Jquery List Pager Plugin -->
    <script type="text/javascript" src="/jsLibs/list-pager/paging.min.js"></script>

    <!-- Quill Rich Text Editor Plugin-->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.rawgit.com/kensnyder/quill-image-resize-module/3411c9a7/image-resize.min.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- Jquery Spinner -->
    <link rel="stylesheet" href="/jsLibs/HoldOnSpinner/HoldOn.min.css" />

</head>

<body class="bg-primary">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid ">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="/public/assets/icon.webp" alt="" height="35px" style="vertical-align: middle;" class="me-2">
                College Notifier
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php if ($request == '/') {
                            echo 'active';
                        } ?>" aria-current="page" href="/">Home</a>
                    </li>
                    <?php
                    if ($user) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($request == '/my-profile') {
                                    echo 'active';
                                } ?> position-relative" href="my-profile">
                                <span class="position-relative">
                                    My Profile
                                    <?php if ($show_counters && $unsubmitted_count) { ?>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?php echo $unsubmitted_count ?><span class="visually-hidden">unread messages</span>
                                        </span>
                                    <?php } ?>
                                </span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php
                    if ($user) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/logout">Logout</a>
                        </li>
                    <?php } ?>
                </ul>
                <span class="navbar-text text-white">
                    <?php
                    if (isset($user['name'])) {
                        echo "<strong>" . $user['name'] . "</strong> | <small class='text-capitalize'>" . $user['type'] . "</small>";
                    }
                    ?>
                </span>
            </div>
        </div>
    </nav>

    <div class="d-flex align-items-center flex-column px-4 pt-2 pb-4" style="min-height: calc(100vh - 56px);">