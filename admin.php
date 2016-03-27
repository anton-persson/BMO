<?php
$title = "Admin";
include("incl/header.php");

// Get the selected page, or the default one
if (getLoggedInUser() === false) {
    $page = (isset($_GET['page'])) ? $_GET['page'] : "login";
} else {
    $page = (isset($_GET['page'])) ? $_GET['page'] : "intro";
}
is_string($page) or die("Incoming value for page must be a string.");

// Array with all valid pages
$multipage = [
    "login" => "login/login.php",
    "failed" => "login/failed.php",
    "intro" => "admin/intro.php",
    "add_article" => "admin/add_article.php",
    "update_article" => "admin/update_article.php",
    "add_object" => "admin/add_object.php",
    "update_object" => "admin/update_object.php",
    "update_frontpage" => "admin/update_frontpage.php",
];

// Get the contentfile to include
if (isset($multipage[$page])) {
    $file = $multipage[$page];
} else {
    die("The value of ?page=" . htmlentities($page) . " is not recognized as a valid page.");
}

?>
<main>
    <article>
        <?php include("$file"); ?>
    </article>
</main>


<?php include("incl/footer.php"); ?>
