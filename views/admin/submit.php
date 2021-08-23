<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/hashing.php';
// require $_SERVER['DOCUMENT_ROOT'] . '/utils/logout.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $lpassword = $_POST['password'];
    require_once $_SERVER['DOCUMENT_ROOT'] . '/db/admin.php';    
    $user = find_admin_user($email);
    if (isset($user['error'])) {
        echo "
        <svg xmlns='http://www.w3.org/2000/svg' style='display: none;'>
            <symbol id='exclamation-triangle-fill' fill='currentColor' viewBox='0 0 16 16'>
                <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
            </symbol>
        </svg>
            <div class='row my-4 text-center'>
                <div class='alert alert-danger d-flex align-items-center' role='alert'>
                    <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                    <div>
                        Some Error Occured. {$user['message']}
                    </div>
                </div>
                <span>Please go back to <a href='admin/signup'>Sign Up/ Login</a></span>
            </div>
        ";
    } elseif (count($user) > 0) {        
        if (password_verify($lpassword, $user[0]['admin_password'])) {
            unset($user[0]['admin_password']);
            $token = encrypt($user[0]['email']);
            setcookie('adminUser', $token, time() + (86400 * 30), '/');
            header('Location:../admin');
            // echo "<script>location.href='../admin'</script>";
        } else {
            echo "
            <svg xmlns='http://www.w3.org/2000/svg' style='display: none;'>
                <symbol id='exclamation-triangle-fill' fill='currentColor' viewBox='0 0 16 16'>
                    <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
                </symbol>
            </svg>
                <div class='row my-4 text-center'>
                    <div class='alert alert-danger d-flex align-items-center' role='alert'>
                        <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                        <div>
                            Email Id or Password is Incorrect, Please try again
                        </div>
                    </div>
                    <span>Please go back to <a href='admin/login'>Login</a></span>
                </div>
            ";
        }
    } else {
        echo "
        <svg xmlns='http://www.w3.org/2000/svg' style='display: none;'>
            <symbol id='exclamation-triangle-fill' fill='currentColor' viewBox='0 0 16 16'>
                <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
            </symbol>
        </svg>
            <div class='row my-4 text-center'>
                <div class='alert alert-danger d-flex align-items-center' role='alert'>
                    <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                <div>
                    Email Id or Password is Incorrect, Please try again
                </div>
            </div>
            <span>Please go back to <a href='admin/login'>Login</a></span>
        </div>
        ";
    }
}

if (isset($_POST['signup'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $spassword = $_POST['password'];
    require_once $_SERVER['DOCUMENT_ROOT'] . '/db/admin.php';
    $hashed = password_hash($spassword, PASSWORD_DEFAULT);
    $user = create_admin($name, $email, $phone, $hashed);
    if (isset($user['error'])) {
        echo "
        <svg xmlns='http://www.w3.org/2000/svg' style='display: none;'>
            <symbol id='exclamation-triangle-fill' fill='currentColor' viewBox='0 0 16 16'>
                <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
            </symbol>
        </svg>
            <div class='row my-4 text-center'>
                <div class='alert alert-danger d-flex align-items-center' role='alert'>
                    <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                <div>
                {$user['message']}
                </div>
            </div>
            <span>Please go back to <a href='admin/signup'>Sign Up/ Login</a></span>
        </div>
        ";
    } elseif (count($user) > 0) {
        unset($user[0]['admin_password']);
        $token = encrypt($user[0]['email']);
        setcookie('adminUser', $token, time() + (86400 * 30), '/');
        header('Location:../../admin');
        // echo "<script>location.href='../admin'</script>";
    }
}