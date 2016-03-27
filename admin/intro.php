<?php
if (getLoggedInUser() === false) {
    die("Du måste vara inloggad för att se denna sidan.");
};
?>
        <header>
            <h1>Administatörsgränssnitt</h1>
            <h3>Inloggad som: <em><?= $details['user'] ?></em></h3>
        </header>
        <p>Du är nu inloggad i admindelen och kan göra förändringar på hemsidan. Du får även tillgång till validatorer och teknisk information i sidfoten</p>
