<?php
$title = "Om BMO";
include("incl/header.php");

// Connects to database and gets the About article
$db = connectToDB();
$sql = "SELECT * FROM Article WHERE category='about'";
$content = getContentFromDB($db, $sql);
?>
<main>
    <article>
        <header>
            <h1><?= $content['title']; ?></h1>
            <p class="author">Publicerad <?= $content['pubdate']; ?></p>
        </header>
            <?= $content['content'] ?>
    </article>
</main>
<?php include("incl/byline.php"); ?>
<?php include("incl/footer.php"); ?>
