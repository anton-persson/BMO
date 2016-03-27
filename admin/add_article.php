<?php
if (getLoggedInUser() === false) {
    die("Du måste vara inloggad för att se denna sidan.");
};
?>
    <header>
        <h1>Lägg till artikel</h1>
    </header>
    <form method="post" action="admin/insert-process.php">
            <input type="hidden" name="id">
            <p><label>Kategori<br><input type="text" name="category"></label></p>
            <p><label>Titel<br><input type="text" name="title"></label></p>
            <p><label>Innehåll<textarea rows="10" cols="70" name="content"></textarea></label></p>
            <p><label>Författare<br><input type="text" name="author"></label></p>
            <p><label>Publiceringsdatum<br><input type="text" name="pubdate" value="<?= date('Y-m-d'); ?>"></label></p>
            <input type="hidden" name="article" value="true">
            <p><input type="submit" name="add" value="Lägg till artikel"></p>
    </form>
