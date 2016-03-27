<?php
include("../incl/config.php");

if (getLoggedInUser() === false) {
    die("Du måste vara inloggad för att se denna sidan.");
};

//Check to see if article or object and set the type
if (isset($_POST['article'])) {
    $type = "Article";
} else if (isset($_POST['object'])) {
    $type = "Object";
}

// Check if form posted and get incoming
if (isset($_POST['delete'])) {
    // Store posted form in parameter array
    $id     = $_POST['id'];
    $params = [$id];

    // Connect to the database
    $db = connectToDB();

    // Prepare SQL statement to delete from the database
    $sql = "DELETE FROM $type WHERE id = ?";
    $stmt = $db->prepare($sql);

    sql_errorcheck($stmt, $params);
}
if (isset($_POST['back'])) {
    header("Location: " . "../admin.php?page=update_" . strtolower($type));
}

// Redirect to the resultpage
header("Location: " . "../admin.php?page=update_" . strtolower($type));
