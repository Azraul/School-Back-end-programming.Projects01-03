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
    <?php $page = 'filer'; include 'meny.php';?>
    <?php include 'besokare.php';?>
    </div>
    <div id="bakgrundHome"></div>
    <div id="mainFrame">
        <div class="mainContent">
            <div class="pageTitle">
                <h1>Ladda upp bilder</h1>
        <?php
if (isset($_SESSION["user"]) or isset($_SESSION["admin"])) {
    echo "<h3>Här kan du ladda upp en profilbild</h3>";
    echo "<form action=\"filerupload.php\" method=\"post\" enctype=\"multipart/form-data\">";
    echo "<p>Välj en profilbild till ditt user account:</p>";
    echo "<input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\">";
    echo "<input type=\"submit\" value=\"Ladda upp\" name=\"submit\">";
    echo "<p>Filen ska vara en bild och max 2mb</p>";
    echo "</form>";
    print("<p>I bilder katalogen finns just nu följande filer:</p>");
$katalog = "bilder/";
$innehall = scandir($katalog);
foreach ($innehall as $line) {
    if (($line != ".") && ($line != "..")) {
        print(" - " . $line . "<br>");
    }

}

} else {
    print("<a href='session.php'>Logga in</a> om du vill ladda upp något");
}


?>
</div>
</div>
</div>
</body>
</html>