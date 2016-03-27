<?php
// Start the session
$name = substr(preg_replace('/[^a-z\d]/i', '', __DIR__), -30);
session_name($name);
session_start();

// Reads the main php-files in the directory and selects current one for the menu.
function selectedPage($phpPage)
{
    $selected = "";
    if (preg_match("/$phpPage/", basename($_SERVER['REQUEST_URI'])) == true) {
            $selected = "selected";
    }
    return $selected;
}

/**
 * Open the database file and catch the exception it it fails,
 * add an explanation and re-throw the exception.
 *
 * @param string $dsn the DSN for the database to connect to.
 *
 * @return PDO as the database connection.
 */

function connectToDB()
{
    // Open the database file and catch the exception it it fails.
    $fileName = __DIR__ . "/../db/bmo2.sqlite";
    $dsn = "sqlite:$fileName";
    try {
        $db = new PDO($dsn);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        echo "<p>Failed to connect to the database using DSN:<br>$dsn</p>";
        throw $e;
    }
}

// Gets single or multiple objects from the database
function getObjects($db, $sql)
{
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

// Gets the content from the database objects
function getContentFromDB($db, $sql)
{
    $results = getObjects($db, $sql);
    $content = $results[0];
    return $content;
}

// Gets all the objects from the database
function getAllObjects()
{
    $db = connectToDB();
    $sql = "SELECT * FROM Object";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

// Primt the selected objects as HTML table
function printObjects($res)
{
    $rows = null;
    foreach ($res as $row) {
        $rows .= "<tr>";
        $rows .= "<td><a href='?id=" . $row['id'] . "'><img src='img/80x80/" . htmlentities($row['image']) . "' alt='" . htmlentities($row['title']) . "'></a></td>";
        $rows .= "<td><a href='?id=" . $row['id'] . "'>" . htmlentities($row['title']) . "</a></td>";
        $rows .= "<td>" . htmlentities($row['category']) . "</td>";
        $rows .= "<td>" . htmlentities($row['text']) . "</td>";
        $rows .= "<td>" . htmlentities($row['owner']) . "</td>";
        $rows .= "</tr>\n";
    }

    echo <<<EOD
    <table class="objectList">
    <thead>
    <tr>
        <th>Bild</th>
        <th>Namn</th>
        <th>Kategori</th>
        <th>Text</th>
        <th>Ägare</th>
    </tr>
    </thead>
    $rows
    </table>
EOD;
}

// Prints a table of all the articles with edit and delete icons
function printArticlesEdit()
{
    $db = connectToDB();
    $sql = "SELECT * FROM Article";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $rows = null;
    foreach ($res as $row) {
        $articleID = htmlentities($row['id']);
        $rows .= "<tr>";
        $rows .= "<td>" . htmlentities($row['category']) . "</td>";
        $rows .= "<td>" . htmlentities($row['title']) . "</td>";
        $rows .= "<td>" . htmlentities($row['author']) . "</td>";
        $rows .= "<td>" . htmlentities($row['pubdate']) . "</td>";
        $rows .= "<td class='dbtools'><a href='?page=update_article&articleID=$articleID&update=true'><svg viewBox='0 0 100 100' class='icon icon-pencil'>
          <use xlink:href='#icon-pencil'></use>
        </svg></a></td>";
        $rows .= "<td class='dbtools'><a href='?page=update_article&articleID=$articleID&delete=true'><svg viewBox='0 0 100 100' class='icon icon-bin'>
          <use xlink:href='#icon-bin'></use>
        </svg></a></td>";
        $rows .= "</tr>\n";
    }

    echo <<<EOD
    <table class="editArticleTable">
    <thead>
    <tr>
        <th>Kategori</th>
        <th>Titel</th>
        <th>Författare</th>
        <th>Publiceringsdatum</th>
        <th>Uppdatera</th>
        <th>Radera</th>
    </tr>
    </thead>
    $rows
    </table>
EOD;
}

// Prints a table of all the objects with edit and delete icons
function printObjectsEdit()
{
    $db = connectToDB();
    $sql = "SELECT * FROM Object";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $rows = null;
    foreach ($res as $row) {
        $objectID = htmlentities($row['id']);
        $rows .= "<tr>";
        $rows .= "<td><img src='img/80x80/" . htmlentities($row['image']) . "'></td>";
        $rows .= "<td>" . htmlentities($row['title']) . "</td>";
        $rows .= "<td>" . htmlentities($row['category']) . "</td>";
        $rows .= "<td>" . htmlentities($row['text']) . "</td>";
        $rows .= "<td>" . htmlentities($row['owner']) . "</td>";
        $rows .= "<td class='dbtools'><a href='?page=update_object&objectID=$objectID&update=true'><svg viewBox='0 0 100 100' class='icon icon-pencil'>
          <use xlink:href='#icon-pencil'></use>
        </svg></a></td>";
        $rows .= "<td class='dbtools'><a href='?page=update_object&objectID=$objectID&delete=true'><svg viewBox='0 0 100 100' class='icon icon-bin'>
          <use xlink:href='#icon-bin'></use>
        </svg></a></td>";
        $rows .= "</tr>\n";
    }

    echo <<<EOD
    <table>
    <thead>
    <tr>
        <th>Bild</th>
        <th>Titel</th>
        <th>Kategori</th>
        <th>Text</th>
        <th>Ägare</th>
        <th>Uppdatera</th>
        <th>Radera</th>
    </tr>
    </thead>
    $rows
    </table>
EOD;
}


// Selects the next object
function objectsIDNext($pageID)
{
    $result = getAllObjects();
    $countAll = count($result);
    if ($pageID == $countAll) {
        return  1;
    } else {
        return $pageID+1;
    }
}

// Selects the previous object
function objectsIDPrev($pageID)
{
    $result = getAllObjects();
    $countAll = count($result);
    if ($pageID == 1) {
        return  $countAll;
    } else {
        return $pageID-1;
    }
}

// Testing and mapping the related objects
function relatedObjectsMap($currentArticle)
{
    switch($currentArticle['title'])
    {
        case 'Begravningskonfekt':
            $related = "('Begravningskonfekt')";
            break;
        case 'Minnestavlor':
            $related = "('Minnestavla')";
            break;
        case 'Pärlkransar':
            $related = "('Pärlkrans')";
            break;
        case 'Begravningsfest och Gravöl - ett stort kalas':
            $related = "('Begravningsfest', 'Begravningstal')";
            break;
        default:
            $related = null;
            break;
    }
    return $related;
}

// Uses an array to get the objects related to an article
function relatedObjects($db, $currentArticle, $single)
{
    $related = relatedObjectsMap($currentArticle);
    if ($related != null && $single == false) {
        $sql = "SELECT * FROM Object WHERE category IN $related";
        $objects = getObjects($db, $sql);
        echo "<h3>Relaterade föremål</h3>";
        foreach ($objects as $content) {
            echo "<figure>";
            echo "<a href='objects.php?id=" . $content['id'] . "'>";
            echo "<img src='img/250x250/" . $content['image'] . "' alt='" . $content['title'] . "'>";
            echo "</a>";
            echo "<figcaption>" . $content['title'] . "</figcaption>";
            echo "</figure>";
        }
    }
    // Select only a single related object for the multiple articles view
    if ($related != null && $single == true) {
        $sql = "SELECT * FROM Object WHERE category IN $related LIMIT 1";
        $objects = getObjects($db, $sql);
        echo "<a href='articles.php?id=" . $currentArticle['id'] . "'>";
        echo "<img class='img-left featured-img borderImg' src='img/250x250/" . $objects[0]['image'] . "' alt='" . $objects[0]['title'] . "'>";
        echo "</a>";
    }
}

// Search the database for the query and return the results
function dbSearch($db, $sql, $search)
{
    $stmt = $db->prepare($sql);

    // Execute the SQL statement using parameters to replace the ?, widesearch adds wildcards on both sides of the search term to increase matches
    $wideSearch = "%" . $search . "%";
    $params = [$wideSearch, $wideSearch];
    $stmt->execute($params);

    $searchResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $searchResult;
}


// Checks for SQL errors when inserting data into the database
function sql_errorcheck($stmt, $params)
{
    // Execute the SQL to INSERT within a try-catch to catch any errors.
    try {
        $stmt->execute($params);
    } catch (PDOException $e) {
        echo "<p>Failed to insert a new row, dumping details for debug.</p>";
        echo "<p>Incoming \$_POST:<pre>" . print_r($_POST, true) . "</pre>";
        echo "<p>The error code: " . $stmt->errorCode();
        echo "<p>The error message:<pre>" . print_r($stmt->errorInfo(), true) . "</pre>";
        throw $e;
    }
}


// Prints out the numbers of image to select and show in the gallery
function imagesToShow($imgNumber, $imagesTotal, $numImages = array(5,8,12))
{
    $selected = "";
    foreach ($numImages as $number) {
        if ($imgNumber == $number) {
            $selected .= " selectedNum";
        } else {
            $selected = "";
        }
        echo "<a href='?imgNumber=" . $number . "' class='imageNumbers" . $selected . "'>" . $number . "</a>";
    }
    if ($imgNumber == $imagesTotal) {
        $selected .= " selectedNum";
    } else {
        $selected = "";
    }
    echo "<a href='?imgNumber=" . $imagesTotal . "' class='imageNumbers" . $selected . "'>Alla</a>";
}

// The paginated gallery navigation
function galleryPagination($pageNumber, $imgNumber, $imagesTotal)
{
    echo "<nav class='galleryPagination'>";
    echo "<ul>";
    if ($pageNumber != 0) {
        echo "<li><a href='?imgNumber=" . $imgNumber . "&pageNumber="  . ($pageNumber-1) . "'>Föregående sida</a></li>";
    }
    for ($i=0; $i <= ceil($imagesTotal/$imgNumber)-1; $i++) {
        $pageNum = $i+1;
        $currentPage = "";
        if ($pageNumber == $i) {
            $currentPage = "currentPage";
        }
        echo "<li><a href='?imgNumber=" . $imgNumber . "&pageNumber="  . $i . "' class='" . $currentPage . "'>" . $pageNum . "</a></li>";
    }
    if ($pageNumber != ceil($imagesTotal/$imgNumber)-1) {
        echo "<li><a href='?imgNumber=" . $imgNumber . "&pageNumber="  . ($pageNumber+1) . "'>Nästa sida</a></li>";
    }
    echo "</ul>";
    echo "</nav>";
}

// Print the links to the adminpages
function adminPages()
{
    $multi = strstr(basename($_SERVER['REQUEST_URI']), '?', true);
    $pages = ['Intro' => '?page=intro', 'Lägg till artikel' => '?page=add_article', 'Uppdatera/radera artikel' => '?page=update_article', 'Lägg till föremål' => '?page=add_object', 'Uppdatera/radera föremål' => '?page=update_object', 'Uppdatera framsida' => '?page=update_frontpage'];
    echo "<nav class=\"navbar admin-nav\">\n";
    echo "<div class=\"container\">\n";
    echo "<ul class=\"navigation\">\n";
    foreach ($pages as $pagekey => $pagevalue) {
        echo "<li>";
        echo "<a ";
        if (basename($_SERVER['REQUEST_URI']) == $multi.$pagevalue) {
            echo 'class="selected" ';
        } else if (($multi == "") && ($pagekey == 'Create')) {
            echo 'class="selected" ';
        }
        echo "href=\"admin.php" . $pagevalue . "\">" . $pagekey . "</a>";
        echo "</li>\n";
    }
    echo "</ul>\n";
    echo "</div>\n";
    echo "</nav>\n";
}


// Create an array of the valid users from the database
$db = connectToDB();
$sql = "SELECT * FROM Users";
$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$users = [
    'admin' => [
        'name'=> $results[0]['username'],
        'password' => $results[0]['password']
    ],
];


/**
 * Get incoming variable from $_POST or set default value.
 *
 * @param $key     use this as key to $_POST.
 * @param $default use this as default it $key is not set in $_POST.
 *
 * @return mixed as either value for $key or $default.
 */
function getPostValueFor($key, $default)
{
    return isset($_POST[$key])
        ? $_POST[$key]
        : $default;
}


/**
 * Check if the user can login with supplied credentials.
 *
 * @param $user     the supplied acronym of the user.
 * @param $password the supplied pasword of the user
 *
 * @return boolean true if user and password matches, else false.
 */
function checkUserAndPassword($user, $password)
{
    global $users;

    $passwordHash = isset($users[$user])
        ? $users[$user]['password']
        : false;

    $res = password_verify($password, $passwordHash);
    return $res;
}


/**
 * Login user and set session if user and password matches.
 *
 * @param $user     the supplied acronym of the user.
 * @param $password the supplied pasword of the user
 *
 * @return boolean true if user and password matches, else false.
 */
function loginUser($user, $password)
{
    $res = checkuserAndPassword($user, $password);

    if ($res === true) {
        $_SESSION['user'] = $user;
    }

    return $res;
}


/**
 * Get details of the logged in user, or false if user is not logged in.
 *
 * @return []|boolean array with details or false if user is not logged in.
 */
function getLoggedInUser()
{
    global $users;

    $user = isset($_SESSION['user'])
        ? $_SESSION['user']
        : false;

    if ($user === false) {
        return false;
    }

    $res['user'] = $user;
    $res['name'] = $users[$user]['name'];
    $res['password'] = $users[$user]['password'];

    return $res;
}


/**
 * Logout user and remove details from the session.
 *
 * @return void.
 */
function logoutUser()
{
    unset($_SESSION['user']);
}
