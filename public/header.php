<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/get_user.php';
$user = get_current_logged_user();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/">
    <title>College Notifier</title>

    <!-- Global CSS  -->
    <link rel="stylesheet" href="public/styles/style.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- Fonr-Awsome Icons  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap Js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>

    <!-- JQuery js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- JQuery Toasts plugin  -->
    <link rel="stylesheet" href="/js-vendor/jquery-toast-plugin-master/dist/jquery.toast.min.css">
    <script src="/js-vendor/jquery-toast-plugin-master/dist/jquery.toast.min.js"></script>

    <!-- JQuery Dialog Plugin -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    <!-- Jquery List Pager Plugin -->
    <script type="text/javascript" src="/js-vendor/list-pager/paging.min.js"></script>

    <!-- Quill Rich Text Editor Plugin-->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.rawgit.com/kensnyder/quill-image-resize-module/3411c9a7/image-resize.min.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

</head>

<body class="bg-primary">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid ">
            <a class="navbar-brand" href="/">College Notifier</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
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
                        <a class="nav-link" href="/logout">Logout</a>
                    </li>
                    <?php } ?>
                </ul>
                <span class="navbar-text text-white">
                    <?php
                    if (isset($user['email'])) {
                        echo $user['email'];
                    }
                    ?>
                </span>
            </div>
        </div>
    </nav>

    <div class="d-flex align-items-center flex-column px-4 pt-4" style="min-height: calc(100vh - 56px);">