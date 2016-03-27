<?php
if (getLoggedInUser() === false) {
    die("Du måste vara inloggad för att se denna sidan.");
};
?>
        <header>
            <h1>Lägg till föremål</h1>
        </header>
        <form method="post" action="admin/insert-process.php">
        <input type="hidden" name="id">
        <p><label>Titel<br><input type="text" name="title"></label></p>
        <p><label>Kategori<br><input type="text" name="category"></label></p>
        <p><label>Text<br>​<input type="text" name="text"></label></p>
        <p><label>Bild<br><input type="text" name="image"></label></p>
        <p><label>Ägare<br><input type="text" name="owner"></label></p>
        <input type="hidden" name="object" value="true">
        <p><input type="submit" name="add" value="Lägg till objekt"></p>
        </form>
