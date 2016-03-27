<?php
if (getLoggedInUser() === false) {
    die("Du måste vara inloggad för att se denna sidan.");
};
?>
        <header>
            <h1>Uppdatera/Radera artikel</h1>
        </header>
        <?php
        $db = connectToDB();
        if (!isset($_GET['articleID'])) {
            $_GET['articleID'] = null;
        }
        if (!isset($_GET['update'])) {
            $_GET['update'] = "false";
        }
        if (!isset($_GET['delete'])) {
            $_GET['delete'] = "false";
        }
        if (!isset($_GET['articleID']) && $_GET['articleID'] == null) {
            printArticlesEdit();
        }
        //
        // Check if script was accessed using specific articleID
        //
        $articleIDs = isset($_GET['articleID'])
            ? $_GET['articleID']
            : null;
        $id = null;
        $category = null;
        $title = null;
        $content = null;
        $author = null;
        $pubdate = null;
        if ($articleIDs) {
            $sql = "SELECT * FROM Article WHERE id = ?";
            $stmt = $db->prepare($sql);
            $params = [$articleIDs];
            $stmt->execute($params);
            // Get the results as an array with column names as array keys
            $res = $stmt->fetchAll(PDO::FETCH_BOTH);

            if (empty($res)) {
                die("No such id.");
            }

            // Move content of array to individual variables, for ease of use.
            list($id, $category, $title, $content, $author, $pubdate) = $res[0];
        }

        if (isset($_GET['articleID']) != null && $_GET['update'] == "true") {
        ?>
        <form method="post" action="admin/update-process.php">
                <p><label>id<br><input type="number" name="id" value="<?=$id?>" readonly></label></p>
                <p><label>Kategori<br><input type="text" name="category" value="<?=$category?>"></label></p>
                <p><label>Titel<br><input type="text" name="title" value="<?=$title?>"></label></p>
                <p><label>Innehåll<br><textarea name="content"><?=$content?></textarea></label></p>
                <p><label>Författare<br><input type="text" name="author" value="<?=$author?>"></label></p>
                <p><label>Publiceringsdatum<br><input type="text" name="pubdate" value="<?=$pubdate?>"></label></p>
                <input type="hidden" name="article" value="true">
                <p><input type="submit" name="back" value="Tillbaka"> <input type="submit" name="update" value="Uppdatera"></p>
        </form>
        <?php
        } else if (isset($_GET['articleID']) != null && $_GET['delete'] == "true") { ?>
        <form method="post" action="admin/delete-process.php">
                <p><label>id<br><input type="number" name="id" value="<?=$id?>" readonly></label></p>
                <p><label>Kategori<br><input type="text" name="category" value="<?=$category?>"></label></p>
                <p><label>Titel<br><input type="text" name="title" value="<?=$title?>"></label></p>
                <input type="hidden" name="article" value="true">
                <p><input type="submit" name="back" value="Tillbaka"> <input type="submit" name="delete" value="Radera"></p>
        </form>
        <?php
        }
        ?>
