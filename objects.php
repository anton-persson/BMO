<?php
$title = "Föremål";
include("incl/header.php");

// Checks and sets the object category
$category = isset($_GET['category']) ? $_GET['category'] : $category="Alla";
is_string($category) or die("Incoming value for a category must be a string.");

// Checks and sets the page ID
$pageID = isset($_GET['id']) ? $_GET['id'] : $pageID="";
is_string($pageID) or die("Incoming value for an id must be a string.");

// Connctes to the database and selects only the DISTINCT (non duplicate) category values
$db = connectToDB();
$sql = "SELECT DISTINCT category FROM Object";
$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_COLUMN);

//Moves all categories to the beginning of the array
array_unshift($results, "Alla");

?>
<main>
        <?php
        // If the pageID is not set, show all the objects
        if ($pageID == null) {?>
            <article>
            <header>
                <h1>Föremål</h1>
            </header>
            <?php
            if ($category == "Alla") {
                $sql = "SELECT * FROM Object";
            } else {
                $sql = "SELECT * FROM Object WHERE category='$category'";
            }
            $res = getObjects($db, $sql);
            echo "<p><em>Antal visade föremål: <strong>" . count($res) . "</strong></em></p>";
            ?>
            <form method="get" action="?category">
                <label><strong>Kategori:</strong></label>
                <?php
                // Prints all the category buttons and adds a class the currently selected category
                foreach ($results as $objectCategory) {
                    $currentCat = "";
                    if ($category == $objectCategory) {
                        $currentCat = " currentCat";
                    }
                    ?>
                    <input type="submit" value="<?= $objectCategory == "Alla" ? "Alla" : $objectCategory; ?>" name="category" class="categoryButtons<?= $currentCat ?>">
                    <?php
                } ?>
            </form>
            <?php
            printObjects($res);
        } else {
            // If the pageID is set, show the object
            $sql = "SELECT * FROM Object WHERE id=$pageID";
            $content = getContentFromDB($db, $sql);
            ?>
            <article class="singleObject">
            <header>
                <h1><?= $content['title']?></h1>
            </header>
            <p class="objectNavButtons">
                <a href="?id=<?= objectsIDPrev($pageID); ?>">Föregående föremål</a>
                <a href="?id=<?= objectsIDNext($pageID); ?>">Nästa föremål</a>
            </p>
            <img src="img/full-size/<?= $content['image'] ?>" alt="<?= $content['title'] ?>">
            <p>
                <strong>Beskrivning: </strong><?= $content['text']; ?><br>
                <strong>Kategori: </strong><?= $content['category']; ?><br>
                <strong>Ägare: </strong><?= $content['owner']; ?>
            </p>
            <?php
        } ?>
    </article>
</main>
<?php include("incl/footer.php"); ?>
