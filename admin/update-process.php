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
} else if (isset($_POST['frontpage'])) {
    $type = "frontpage";
}

// Check if form posted and get incoming
if (isset($_POST['update'])) {
    if (isset($_POST['article'])) {
    // Store posted form in parameter array
        $id           = $_POST['id'];
        $category     = $_POST['category'];
        $title        = $_POST['title'];
        $content      = $_POST['content'];
        $author       = $_POST['author'];
        $pubdate      = $_POST['pubdate'];

        $params = [$category, $title, $content, $author, $pubdate, $id];

        // Connect to the database
        $db = connectToDB();
        // Prepare SQL statement to update the database
        $sql = <<<EOD
UPDATE Article
SET
    category = ?,
    title = ?,
    content = ?,
    author = ?,
    pubdate = ?
WHERE
    id = ?
EOD;
        $stmt = $db->prepare($sql);
        sql_errorcheck($stmt, $params);
    } else if (isset($_POST['object'])) {
        // Store posted form in parameter array
        $id           = $_POST['id'];
        $title        = $_POST['title'];
        $category     = $_POST['category'];
        $text         = $_POST['text'];
        $image        = $_POST['image'];
        $owner        = $_POST['owner'];

        $params = [$title, $category, $text, $image, $owner, $id];

        // Connect to the database
        $db = connectToDB();
        // Prepare SQL statement to update the database
        $sql = <<<EOD
UPDATE Object
SET
    title = ?,
    category = ?,
    text = ?,
    image = ?,
    owner = ?
WHERE
    id = ?
EOD;
        $stmt = $db->prepare($sql);
        sql_errorcheck($stmt, $params);

    } else if (isset($_POST['frontpage'])) {
        // Store posted form in parameter array
        $title      = $_POST['title'];
        $content    = $_POST['content'];
        $author     = $_POST['author'];
        $pubdate    = $_POST['pubdate'];

        $params = [$title, $content, $author, $pubdate];

        // Connect to the database
        $db = connectToDB();
        // Prepare SQL statement to update the database
        $sql = <<<EOD
UPDATE Content
SET
    title = ?,
    content = ?,
    author = ?,
    pubdate = ?
WHERE
    type = 'frontpage'
EOD;
        $stmt = $db->prepare($sql);
        sql_errorcheck($stmt, $params);
    }
}

if (isset($_POST['back'])) {
    header("Location: " . "../admin.php?page=update_" . strtolower($type));
}
// Redirect to the resultpage
header("Location: " . "../admin.php?page=update_" . strtolower($type));
