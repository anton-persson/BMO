<?php
$title = "Begravningsmuseum Online";
include("incl/header.php");

$db = connectToDB();
$sql = "SELECT * FROM Content WHERE type LIKE 'frontpage'";
$content = getContentFromDB($db, $sql);
?>
<main>
    <article>
        <header>
            <h1><?= $content['title'] ?></h1>
        </header>
            <?= $content['content'] ?>
    </article>
    <div class="row">
        <div class="thirds">
            <h2>Senaste artiklarna</h2>
            <ul class="lastestArticles">
            <?php
            // Gets the six latest articles
            $sql = "SELECT * FROM Article WHERE category='article' OR category='maggy' ORDER BY pubdate DESC LIMIT 6";
            $results = getObjects($db, $sql);
            foreach ($results as $article) { ?>
                <li><a href="articles.php?id=<?= $article['id'] ?>"><?= $article['title'] ?></a></li>
            <?php
            } ?>
            </ul>
        </div>
        <div class="thirds">
            <h2>Föremål från samlingen</h2>
            <?php
            // Gets 9 random objects
            $sql = "SELECT * FROM OBJECT ORDER BY RANDOM() LIMIT 9";
            $results = getObjects($db, $sql);
            foreach ($results as $object) { ?>
                <a href="objects.php?id=<?= $object['id'] ?>"><img class="borderImg" alt="<?= $object['title'] ?>" src="img/80x80/<?= $object['image'] ?>"></a>
            <?php
            } ?>
        </div>
        <div class="thirds">
            <h2>Bild från galleriet</h2>
            <?php
            // Gets one random object
            $sql = "SELECT * FROM OBJECT ORDER BY RANDOM() LIMIT 1";
            $results = getObjects($db, $sql);
            foreach ($results as $object) { ?>
            <figure>
                <a href="gallery.php?imgID=<?= $object['id'] ?>&amp;pageNumber=<?= ceil($object['id']/5)-1 ?>"><img alt="<?= $object['title'] ?>" src="img/250x250/<?= $object['image'] ?>"></a>
                <figcaption><?= $object['title'] ?></figcaption>
            </figure>
            <?php
            } ?>
        </div>
    </div>
</main>
<?php include("incl/footer.php"); ?>
