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
    <?php $page = 'session'; include 'meny.php';?>
    <?php include 'besokare.php';?>
    </div>
    <div id="bakgrundHome"></div>
    <div id="homeFrame">
        <div class="mainContent">
            <div class="pageTitle">
                <h1>Logga in</h1>
    <form action="session.php" method="get">
    <span class="formName">Användare: </span><input type="text" name="anv" placeholder="pleb"><br>
    <span class="formName">Lösenord: </span><input type="text" name="losen" placeholder="proUser"><br>
    <span class="formName">&nbsp;</span><input type="submit" name="login" value="Logga In">
    </form>

    <?php

//kolla användardata function w3schools
function test_input($data)
{
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;

}

if (isset($_GET["login"])) {
    $anv = test_input($_GET["anv"]);
    $losen = test_input($_GET["losen"]);
    if (($anv == "pleb") and ($losen == "proUser")) {
        $_SESSION["user"] = $anv;
        header("Location: index.php");
        exit();
    } elseif (($anv == "admin") and ($losen == "1234")) {
        $_SESSION["admin"] = $anv;
        header("Location: index.php");
        exit();
    } else {
        print("Fel användare eller lösenord, kom ihåg att det är case-sensative");
    }
}

?>
</div>
</div>
</div>
</body>
</html>