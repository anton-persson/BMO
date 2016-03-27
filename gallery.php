<?php
$title = "Bildgalleri";
include("incl/header.php");

// Set how many small images to be selectable
$numImages = [5,8,12];

// Number of small images to show
$imgNumber = isset($_GET['imgNumber']) ? $_GET['imgNumber'] : $imgNumber=strval($numImages[0]);
is_string($imgNumber) or die("Incoming value for image number must be a string.");

// Current page number
$pageNumber = isset($_GET['pageNumber']) ? $_GET['pageNumber'] : $pageNumber="0";
is_string($pageNumber) or die("Incoming value for page number must be a string.");

// Calulates the next page ID for to show the correct large image when changing page
$nextPageID = $imgNumber * $pageNumber + 1;

// Current image ID
$imgID = isset($_GET['imgID']) ? $_GET['imgID'] : $imgID=strval($nextPageID);
is_string($imgID) or die("Incoming value for image ID must be a string.");

// Connects to database and gets total number of images, current image and list of images based on selected number to show
$db = connectToDB();

//Gets the total number of images
$sql = "SELECT image FROM Object";
$imagesTotal = count(getObjects($db, $sql));

//Gets the current image
$sql = "SELECT * FROM Object WHERE id=$imgID";
$currentImg = getObjects($db, $sql);

//Gets small images limited by the set number and a calculated offset starting at 0
$sql = "SELECT * FROM Object LIMIT $imgNumber OFFSET $imgNumber*$pageNumber";
$content = getObjects($db, $sql);

// Checks to make sure the previous and next buttons goes round the index and never gets a false id
if ($imgID < $imagesTotal) {
    $nextImg = $imgID+1;
} else {
    $nextImg = 1;
}
$prevImg = $imgID-1;

if ($prevImg == 0) {
    $prevImg = $imagesTotal;
}

// Calculates the correct pageNumber for the previous and next buttons 
$nextPage = ceil($nextImg/$imgNumber)-1;
$prevPage = ceil($prevImg/$imgNumber)-1;

?>
<main>
    <article>
        <header>
            <h1>Bildgalleri</h1>
        </header>
            <p class="naviSmall">
                <span class="smallImages">Antal små bilder att visa: <?php imagesToShow($imgNumber, $imagesTotal, $numImages) ?></span>
                </p>
            <div class="gallery-large">
                <span class="imgNav objectNavButtons"><a href="?imgNumber=<?= $imgNumber ?>&amp;pageNumber=<?= $prevPage ?>&amp;imgID=<?= $prevImg ?>">Föregående bild</a></span>
                <figure>
                    <a href="objects.php?id=<?= $currentImg[0]['id'] ?>"><img src="img/550x550/<?= $currentImg[0]['image'] ?>" alt="<?= $currentImg[0]['title'] ?>"></a>
                    <figcaption><?= $currentImg[0]['title'] ?></figcaption>
                </figure>
                <span class="imgNav objectNavButtons"><a href="?imgNumber=<?= $imgNumber ?>&amp;pageNumber=<?= $nextPage ?>&amp;imgID=<?= $nextImg ?>">Nästa bild</a></span>
            </div>
            <div class="gallery-small">
            <?php
            // Prints the small images and adds a selected class to the current one
            foreach ($content as $image) {
                if ($image['id'] == $currentImg[0]['id']) {
                    $selectedImg = "selectedImg";
                } else {
                    $selectedImg = "";
                }
                ?>
                <a href="?imgNumber=<?= $imgNumber?>&amp;pageNumber=<?= $pageNumber?>&amp;imgID=<?= $image['id'] ?>" class="<?= $selectedImg ?>"><img src="img/80x80/<?= $image['image'] ?>" alt="<?= $image['title'] ?>"></a>
            <?php
            } ?>
            </div>
            <?php galleryPagination($pageNumber, $imgNumber, $imagesTotal) ?>
    </article>
</main>
<?php include("incl/footer.php"); ?>
