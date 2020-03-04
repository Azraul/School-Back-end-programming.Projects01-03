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
<body></body>
<div id="navbar">
    <?php $page='session'; include 'meny.php';?>
    <?php include 'besokare.php';?>
    </div>
    <div id="bakgrundHome"></div>
    <div id="homeFrame">
        <div class="mainContent">
            <div class="pageTitle">
                <h1>Logga ut</h1>
    <?php

// remove all session variables
//session_unset();

// destroy the session
session_destroy();

echo "Tack för att du loggade ut<br>";
echo "<a href='index.php'>Kom tillbaka snart igen!</a>"
?>
<?php
//Sätter dig tillbaka som guest, borde igentligen göra en redirect här
//men får helatiden en ny session på index då som registrerar en ny besökare vilket blir fel
session_start();
$_SESSION["guest"] = "guest";
?>
</div>
</div>
</div>
</body>
</html>