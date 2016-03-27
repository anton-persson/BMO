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
if (isset($_POST['add'])) {
    if (isset($_POST['article'])) {
    // Store posted form in parameter array
        $id           = null;
        $category     = $_POST['category'];
        $title        = $_POST['title'];
        $content      = $_POST['content'];
        $author       = $_POST['author'];
        $pubdate      = $_POST['pubdate'];

        $params = [$id, $category, $title, $content, $author, $pubdate];

    } else if (isset($_POST['object'])) {
    // Store posted form in parameter array
        $id           = null;
        $title        = $_POST['title'];
        $category     = $_POST['category'];
        $text         = $_POST['text'];
        $image        = $_POST['image'];
        $owner        = $_POST['owner'];

        $params = [$id, $title, $category, $text, $image, $owner];
    }

    // Connect to the database
    $db = connectToDB();

    // Prepare SQL statement to INSERT new rows into table
    $sql = "INSERT INTO $type VALUES(?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);

    sql_errorcheck($stmt, $params);
}

// Redirect to the resultpage
header("Location: " . "../admin.php?page=update_" . strtolower($type));
