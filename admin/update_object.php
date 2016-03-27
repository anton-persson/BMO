<?php
if (getLoggedInUser() === false) {
    die("Du måste vara inloggad för att se denna sidan.");
};
?>
        <header>
            <h1>Uppdatera/Radera föremål</h1>
        </header>
        <?php
        $db = connectToDB();
        if (!isset($_GET['objectID'])) {
            $_GET['objectID'] = null;
        }
        if (!isset($_GET['update'])) {
            $_GET['update'] = "false";
        }
        if (!isset($_GET['delete'])) {
            $_GET['delete'] = "false";
        }
        if (!isset($_GET['objectID']) && $_GET['objectID'] == null) {
            printObjectsEdit();
        }
        //
        // Check if script was accessed using specific articleID
        //
        $objectIDs = isset($_GET['objectID'])
            ? $_GET['objectID']
            : null;
        $id = null;
        $title = null;
        $category = null;
        $text = null;
        $image = null;
        $owner = null;
        if ($objectIDs) {
            $sql = "SELECT * FROM Object WHERE id = ?";
            $stmt = $db->prepare($sql);
            $params = [$objectIDs];
            $stmt->execute($params);
            // Get the results as an array with column names as array keys
            $res = $stmt->fetchAll(PDO::FETCH_BOTH);

            if (empty($res)) {
                die("No such id.");
            }

            // Move content of array to individual variables, for ease of use.
            list($id, $title, $category, $text, $image, $owner) = $res[0];
        }

        if (isset($_GET['objectID']) != null && $_GET['update'] == "true") {
        ?>
        <form method="post" action="admin/update-process.php">
                <p><label>id<br><input type="number" name="id" value="<?=$id?>" readonly></label></p>
                <p><label>Titel<br><input type="text" name="title" value="<?=$title?>"></label></p>
                <p><label>Kategori<br><input type="text" name="category" value="<?=$category?>"></label></p>
                <p><label>Text<br><input type="text" name="text" value="<?=$text?>"></label></p>
                <p><label>Bild<br><input type="text" name="image" value="<?=$image?>"></label></p>
                <p><label>Ägare<br><input type="text" name="owner" value="<?=$owner?>"></label></p>
                <input type="hidden" name="object" value="true">
                <p><input type="submit" name="back" value="Tillbaka"> <input type="submit" name="update" value="Uppdatera"></p>
        </form>
        <?php
        } else if (isset($_GET['objectID']) != null && $_GET['delete'] == "true") { ?>
        <form method="post" action="admin/delete-process.php">
                <p><label>id<br><input type="number" name="id" value="<?=$id?>" readonly></label></p>
                <p><label>Kategori<br><input type="text" name="category" value="<?=$category?>"></label></p>
                <p><label>Titel<br><input type="text" name="title" value="<?=$title?>"></label></p>
                <input type="hidden" name="object" value="true">
                <p><input type="submit" name="back" value="Tillbaka"> <input type="submit" name="delete" value="Radera"></p>
        </form>
        <?php
        }
        ?>
