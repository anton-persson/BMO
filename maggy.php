<?php
$title = "Begravningsseder och bruk";
include("incl/header.php");

// Connects to database and gets the Maggy article
$db = connectToDB();
$sql = "SELECT * FROM Article WHERE category='maggy'";
$content = getContentFromDB($db, $sql);
?>
<main>
    <aside class="side-menu"><?php include("incl/aside.php");?></aside>
        <article class="side-content maggy">
        <header>
            <h1><?= $content['title']; ?></h1>
            <p class="author">Publicerad <?= $content['pubdate'] ?>  &nbsp;|&nbsp;  <?= $content['author'] ?> </p>
        </header>
            <?= $content['content'] ?>
    </article>
</main>
<?php include("incl/footer.php"); ?>
