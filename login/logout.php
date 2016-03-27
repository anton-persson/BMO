<form method="post" action="login/logout-process.php">
    <label class="login-user"><?php echo "Inloggad som: <em>" . $details['user'] . "</em>"; ?></label>
    <button type="submit" name="logout" class="logout-button">
        <svg viewBox="0 0 100 100" class="icon icon-unlocked">
            <use xlink:href="#icon-unlocked"></use>
        </svg>Logga ut</button>
</form>
