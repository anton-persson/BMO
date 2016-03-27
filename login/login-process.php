<?php
// Include common details
include("../incl/config.php");



// Check if form is submitted and try to login user
$submitted = getPostValueFor('login', false);


if ($submitted !== false) {
    $user     = getPostValueFor('user', null);
    $password = getPostValueFor('password', null);
    $success  = loginUser($user, $password);

    if ($success === true) {
        header("Location: ../admin.php?page=intro");
        exit;
    }
}

// Failed to login, redirect to login-page again.
header("Location: ../admin.php?page=login&failed=true");
