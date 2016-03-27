<nav>
    <ul>
        <li>Artiklar</li>
    <?php
    // Gets the articles and maggys article from the database
    $db = connectToDB();
    $sql = "SELECT * FROM Article WHERE category='article' OR category='maggy' ORDER BY pubdate DESC";
    $results = getObjects($db, $sql);
    // Gets the current article url without the GET data
    $multi = strstr(basename($_SERVER['REQUEST_URI']), '?', true);
    foreach ($results as $article) {
        $url = $multi . "?id=" . $article['id'];
        echo '<li><a ';
        // Checks if the current page is selected and does a separate check for maggys page
        if (basename($_SERVER['REQUEST_URI']) == $url || basename($_SERVER['REQUEST_URI']) == 'maggy.php' && $article['id'] == "6") {
            echo 'class="selected"';
        }
        // Separate link for maggy
        if ($article['category'] == 'maggy') {
            echo " href='maggy.php'>" . $article['title'] ."</a></li>";
        } else {
            echo " href='articles.php?id=" . $article['id'] . "'>" . $article['title'] ."</a></li>";
        }
    }
    ?>
    </ul>
</nav>
