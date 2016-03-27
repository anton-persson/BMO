<?php
include("../incl/config.php");

// Check if form is submitted and try to login user
$submitted = getPostValueFor('logout', false);

if ($submitted !== false) {
    logoutUser();
    header("Location: ../admin.php?page=login");
    exit;
}

// Error condition, should not really come here if the form is okey.
header("Location: ../index.php");
