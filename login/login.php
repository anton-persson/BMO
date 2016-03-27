<div class="login">
    <header>
        <h1>Inloggning</h1>
    </header>
    <form class="loginform" method="post" action="login/login-process.php">
        <p>
            <label for="user_login">
                Användarnamn
                <br>
                <input class="input" type="text" size="20" value="" name="user">
            </label>
        </p>
        <p>
            <label for="user_pass">
                Lösenord
                <br>
                <input class="input" type="password" size="20" value="" name="password">
            </label>
        </p>
        <p class="submit">
            <input class="button" type="submit" value="Logga in" name="login">
        </p>
    </form>
    <?php
    if (isset($_GET['failed']) && $_GET['failed'] == 'true') {
        echo "Inloggningen misslyckades, ange korrekt användarnamn och lösenord. <em>(admin/admin)</em>";
    } ?>
</div>
