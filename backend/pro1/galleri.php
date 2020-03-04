<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Kristoffers PHP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
<div id="navbar">
    <?php $page = 'galleri';include 'meny.php';?>
    <?php include 'besokare.php';?>
    </div>
    <div id="bakgrundHome"></div>
    <div id="mainFrame">
        <div class="mainContent">
            <div class="pageTitle">
                <h1>Uppladdade bilder</h1>
   <?php
if (isset($_SESSION["user"]) or isset($_SESSION["admin"])) {
    /**** Dynamiskt bildgalleri med guiden:
     **** https://thevdm.com/2014/10/25/a-very-simple-php-photo-gallery/
     ****/

    $galleryDir = 'bilder/';

    //glob kollar ändelsen och BRACE gör i princip 'or' mellan alla statements
    //'*' gör att första bokstaven måste vara rätt annars hoppar den direkt och kollar nästa
    //Tar gärna en kommentar om jag missförstod det!
    foreach (glob("$galleryDir{*.jpg,*.gif,*.png,*.jpeg}", GLOB_BRACE) as $photo) {
        $imgName = explode("/", $photo);
        $imgName = end($imgName);

        //Kom ihåg att ta bort in-line style
        echo "<a href='$photo' title='$imgName'>";
        echo "<div class=\"fotoBox\"'>";
        echo "<img src='$photo' class=\"foto\"'><br><span class=\"fotoNamn\">$imgName</span>";
        echo "</div>";
        echo "</a>";
    }
}
else {
    print("<a href='session.php'>Logga in</a> om du vill se något.");
}

?>
</div>
</div>
</div>
</body>
</html>