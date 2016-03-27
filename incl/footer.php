<footer class="site-footer">
    <?php
    if (getLoggedInUser() == true) {
    ?>
    <div class="admin-footer">
        <h4>Validatorer</h4>
        <a href="http://validator.w3.org/check/referer">HTML5</a>
        <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>
        <a href="http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance">Unicorn</a>
        <?php
        $numFiles   = count(get_included_files());
        $memoryUsed = round(memory_get_peak_usage(true) / 1024 / 1024, 2);
        $loadTime   = round((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000, 3);
        ?>
        <p><strong>Laddningstid:</strong> <?=$loadTime?> ms <strong>Inkluderade filer:</strong> <?=$numFiles?> <strong>Minnesanvändning:</strong> <?=$memoryUsed?> MB</p>
    </div>
    <?php
    }
    ?>
    <div class="container">
        <small class="copyright">Copyright © <?= date('Y') ?> Blekinge Tekniska Högskola &amp; Anton Persson</small>
        <small><em>Denna webbplatsen har ingen koppling till det befintliga Begravningsmuseum som fortfarande finns i Ljungby.</em></small>
    </div>
</footer>
</body>
</html>
