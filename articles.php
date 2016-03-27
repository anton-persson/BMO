<?php
$pageID = isset($_GET['id']) ? $_GET['id'] : $pageID="";
is_string($pageID) or die("Incoming value for page id must be a string.");

$title = "Artiklar";
include("incl/header.php");

// Connects to database and gets all the articles or just one based one the page ID
$db = connectToDB();
if ($pageID == null) {
    $sql = "SELECT * FROM Article WHERE category='article' OR category='maggy' ORDER BY pubdate DESC";
    $articles = getObjects($db, $sql);
} else {
    $sql = "SELECT * FROM Article WHERE id=$pageID";
    $article = getObjects($db, $sql);
    $content = $article[0];
}

?>
<main>
    <aside class="side-menu"><?php include("incl/aside.php");?></aside>
    <article class="side-content<?= " " . strtolower($title) ?>">
        <header>
        <?php
        // If no pageID is set all articles will be shown
        if ($pageID == null) { ?>
            <h1>Artiklar</h1>
        </header>
        <?php
        foreach ($articles as $article) {
            echo "<h2><a href='?id=" . $article['id'] . "'>" .  $article['title'] . "</a></h2>";
            echo "<p class='author'>" . $article['pubdate']. "</p>";
            // Shows the first related object is the article has one
            relatedObjects($db, $article, $single = true);
            // Gets the first paragraph of the article and prints it if it has one
            preg_match("#<p[^>]*>(.*)</p>#isU", $article['content'], $matches);
            if ($matches != null) {
                echo $matches[0];
            }
            echo "<a href='?id=" . $article['id'] . "'>Läs mer...</a>";
            echo "<hr>";
        } ?>
        <?php
        } else {
        // Single article will be shown
        ?>
            <h1><?= $content['title'] ?></h1>
            <p class="author"> Publicerad <?= $content['pubdate'] ?> &nbsp;|&nbsp; <?= $content['author'] ?></p>
        </header>
        <?php
        echo $content['content'];
        // Related objects will only be shown if there are any based on the title
        relatedObjects($db, $content, $single = false);
        } ?>
    </article>
</main>
<?php include("incl/footer.php"); ?>
