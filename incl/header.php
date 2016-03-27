<?php
include("incl/config.php");
?>
<!doctype html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <title><?= $title . " | BMO" ?></title>
    <link href="css/style.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Adamina' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,600,700,500' rel='stylesheet' type='text/css'>
    <link rel='shortcut icon' href='img/favicon.ico?v=3'/>
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="js/small-menu.js" type="text/javascript"></script>
    <?php
    if (getLoggedInUser() == true) { ?>
    <script type="text/javascript" src='//cdn.tinymce.com/4/tinymce.min.js'></script>
    <script type="text/javascript">
    tinymce.init({
      selector: 'textarea',
      language_url : 'js/sv_SE.js',
      language: 'sv_SE',
      theme: 'modern',
      plugins: [
        'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
        'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
        'save table contextmenu directionality emoticons template paste textcolor'
      ],
      content_css: 'css/content.css, https://fonts.googleapis.com/css?family=Raleway, https://fonts.googleapis.com/css?family=Adamina',
      toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons'
    });
    </script>
    <?php
    } ?>
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=2.0;">
</head>
<body>
    <?php include_once("img/symbol-defs.svg"); ?>
    <header class="site-header">
        <div class="admin-bar">
            <div class="container">
            <?php
            if (getLoggedInUser() == true) {
                $details = getLoggedInUser();
                include("login/logout.php");
            } else { ?>
                    <a href="admin.php" class="login-link">
                    <svg viewBox="0 0 100 100" class="icon icon-lock">
                      <use xlink:href="#icon-lock"></use>
                    </svg>Logga in</a>
            <?php
            }
            ?>
            </div>
        </div>
        <div class="container">
            <span class="site-title"><a href="index.php">Begravningsmuseum Online</a></span>
            <span class="site-slogan">Seder &amp; bruk kring begravningar</span>
            <div class="search-wrapper">
                <form class="search-form" action="search.php" method="get" role="search">
                    <label>
                        <input class="search-field" type="search" title="Sök efter:" name="search" value="" placeholder="Sök efter artiklar och föremål..." required="">
                    </label>
                        <input class="search-submit" type="submit" value="Sök">
                </form>
            </div>
        </div>
    </header>
    <nav class="navbar">
        <h3 class="menu-toggle hidden"><svg viewBox="0 0 100 100" class="icon icon-menu">
          <use xlink:href="#icon-menu"></use>
        </svg> Meny</h3>
        <div class="container">
            <ul class="navigation">
                <li><a class="<?= selectedPage("index.php"); ?>" href="index.php">
                    <svg viewBox="0 0 100 100" class="icon icon-home3">
                      <use xlink:href="#icon-home3"></use>
                    </svg>Hem</a></li>
                <li><a class="<?= selectedPage("maggy.php"); ?>" href="maggy.php">Begravningsseder och bruk</a></li>
                <li><a class="<?= selectedPage("articles.php"); ?>" href="articles.php">Artiklar</a></li>
                <li><a class="<?= selectedPage("objects.php"); ?>" href="objects.php">Föremål</a></li>
                <li><a class="<?= selectedPage("gallery.php"); ?>" href="gallery.php">Bildgalleri</a></li>
                <li><a class="<?= selectedPage("about.php"); ?>" href="about.php">Om BMO</a></li>
            </ul>
        </div>
    </nav>
    <?php
    if (getLoggedInUser() == true) {
        adminPages();
    } ?>
    <?php
    // Show the wide presentation only on the front page
    if (basename($_SERVER['PHP_SELF']) == 'index.php') { ?>
    <div class="presentation">
        <div class="container">
            <h1>Begravningsmuseum Online finns för att vårda ett kulturarv av seder och bruk kring begravningar.</h1>
        </div>
    </div>
    <?php
    } ?>
