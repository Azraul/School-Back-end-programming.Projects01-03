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
} else {
    print("<a href='session.php'>Logga in</a> om du vill ladda upp något");
}

?>


    <?php
//w3 schools upload.php

$katalog = "bilder/";
$target_file = $katalog . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "<br>Filen är en bild - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "<br>Det här var ju ingen bild";
        $uploadOk = 0;
        exit();
    }

// Check if file already exists
    if (file_exists($target_file)) {
        echo "<br>Den här filen finns redan";
        $uploadOk = 0;
        exit();
    }
// Check file size
    if ($_FILES["fileToUpload"]["size"] > 200000) {
        echo "<br>Gör bilden mindre, helst i paint";
        $uploadOk = 0;
        exit();
    }
// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "<br>Bara JPG, JPEG, PNG & GIF Får komma.";
        $uploadOk = 0;
        exit();
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<br>De blev någe fel med din upploaddning";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "<br>Filen " . basename($_FILES["fileToUpload"]["name"]) . " blev upladdad.";
            echo '<li><a href="galleri.php">Se själv!</a></li>';

        } else {
            echo "<br>De blev någe fel med din uppladdning";
            echo '<li><a href="filer.php">Försök igen?</a></li>';
            exit();
        }
    }
}
?>    
</div>
</div>
</div>
</body>
</html>