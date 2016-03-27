<?php
if (getLoggedInUser() === false) {
    die("Du måste vara inloggad för att se denna sidan.");
};
?>
        <header>
            <h1>Uppdatera framsida</h1>
        </header>
        <?php
        $db = connectToDB();
        $sql = "SELECT * FROM Content WHERE type='frontpage'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        // Get the results as an array with column names as array keys
        $res = $stmt->fetchAll(PDO::FETCH_BOTH);
            // Move content of array to individual variables, for ease of use.
        list(, , $title, $content, $author, $pubdate) = $res[0];
        ?>
        <form method="post" action="admin/update-process.php">
                <p><label>Titel<br><input type="text" name="title" value="<?=$title?>"></label></p>
                <p><label>Innehåll<br><textarea rows="10" cols="70" name="content"><?=$content?></textarea></label></p>
                <p><label>Författare<br><input type="text" name="author" value="<?=$author?>"></label></p>
                <p><label>Publiceringsdatum<br><input type="text" name="pubdate" value="<?=$pubdate?>"></label></p>
                <input type="hidden" name="frontpage" value="true">
                <p><input type="submit" name="update" value="Uppdatera"></p>
        </form>
