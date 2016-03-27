<?php
$title = "Sök";
include("incl/header.php");

$search = isset($_GET['search'])
    ? $_GET['search']
    : null;
?>
<main>
    <article class="searchResults">
        <header>
            <h1>Sökresultat</h1>
        </header>
            <?php
            $db = connectToDB();
            // Searches articles both in title and content
            $sql = "SELECT * FROM Article WHERE category='article' AND (title LIKE ? OR content LIKE ?)";
            $searchResultArticles = dbSearch($db, $sql, $search);

            // Searches object titles and text
            $sql = "SELECT * FROM Object WHERE title LIKE ? OR text like ?";
            $searchResultObjects = dbSearch($db, $sql, $search);

            if (empty($searchResultArticles) && empty($searchResultObjects)) {
                echo "<p>Din sökning efter <em>\"" . $search . "\"</em> gav inga träffar</p>";
            } else {
                $totalHits = count($searchResultArticles)+count($searchResultObjects);
                echo "<p>Din sökning efter <em>\"" . $search . "\"</em> gav <strong>" . $totalHits . "</strong> st träffar.</p>";
                echo "<h2>" . count($searchResultArticles) . " st träffar i Artiklar</h2>";
                foreach ($searchResultArticles as $result) {
                    echo "<h3><a href='articles.php?id=" . $result['id'] . "'>" . $result['title'] . "</a></h3>";
                    // Prints only the first 300 characters and respects whole words
                    $pos = strpos($result['content'], ' ', 300);
                    echo substr($result['content'], 0, $pos) . "[...]";
                    echo "<p><a href='articles.php?id=" . $result['id'] . "'>" . "Läs mer..." . "</a></p>";
                    echo "<hr>";
                }
                echo "<h2>" . count($searchResultObjects) . " st träffar i Föremål</h2>";
                foreach ($searchResultObjects as $result) {
                    echo "<div class='searchResultObjects'>";
                    echo "<a href='objects.php?id=" . $result['id'] . "'><img class='img-left borderImg' alt='" . $result['title'] . "' src='img/80x80/" . $result['image'] . "'></a>";
                    echo "<h3><a href='objects.php?id=" . $result['id'] . "'>" . $result['title'] . "</a></h3>";
                    echo "<p>" . $result['text'] . "</p>";
                    echo "</div>";
                    echo "<hr>";
                }
            }
            ?>
    </article>
</main>
<?php include("incl/footer.php"); ?>
