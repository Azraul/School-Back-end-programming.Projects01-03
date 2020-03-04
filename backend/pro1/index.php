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
    <?php $page = 'index'; include 'meny.php';?>
    <?php include 'besokare.php';?>
    </div>
    <div id="bakgrundHome"></div>
    <div id="homeFrame">
        <div class="mainContent">
            <div class="pageTitle">
                <h1> Hem  </h1>
                <?php include 'dagens.php';?>

    <?php

/********* Uppgift 5 *****************
 *** Kolla om man varit här tidigare *
 *** tar tiden man var här konvertar *
 *** den med DateTime annars får man *
 *** en ny cookie med time() *********/

if (isset($_COOKIE['UserVisit'])) {
    $last = $_COOKIE['UserVisit'];
    echo "Välkommen tillbaka <br> Du var här senast den ";
    $lastVisit = new DateTime();
    $lastVisit->setTimestamp($last);
    echo $lastVisit->format('m-d H:i:s') . "<br>";
    
    //Första gången man var här
    if (isset($_COOKIE['UserFirstVisit'])){
    $firstVisit = new DateTime();
    $firstVisit->setTimestamp($_COOKIE['UserFirstVisit']);
    echo "<p>Första gången du var här var: " . $firstVisit->format('Y-m-d') . "</p>";
    }

    //30 dagar expire
    $expire = 2592000 + time();
    setcookie('UserVisit', time(), $expire);
} else {
    echo "Välkommen till min sida!";

    //30 dagar expire
    $expire = 2592000 + time();
    setcookie('UserVisit', time(), $expire);

    //Första gången man var här, 5år expiere
    $expire = 157680000 + time();
    setcookie('UserFirstVisit', time(), $expire);

    //Kan slänga in det här i besokIP också så sedan admins kan läsa
    $firstVisit = new DateTime();
    $handler = fopen("besokIP.log", "a+") or die("Filen gick inte att öppna");
    $txt = "IP: " . $_SERVER['REMOTE_ADDR'] . "|| tid: " . $firstVisit->format('Y-m-d H:i:s') . "\n";
    fwrite($handler, $txt);
    fclose($handler);
}

/********* Uppgift 1 ********************
 **** Visar lite olika php kommandon ****
 **** t.ex. tid, ip, port ***************
 **** vart php:n körs ifrån *************
 **** samt vilka versioner som används***
 ****************************************/

echo "<p><b>Uppgift 1</b></p>";
$tid = date("H:i:s d F y");
echo "<p> Serverns tid: " . $tid . "<p>";
echo "<p>Din server snurrar på port nr: " . $_SERVER["SERVER_PORT"] . ".</p>";
echo "<p>Du tittar på följande sida: " . $_SERVER['PHP_SELF'] . ".</p>";
echo "<p> Från servern: " . $_SERVER['SERVER_NAME'] . ".</p>";
echo "<p>Av hosten: " . $_SERVER['HTTP_HOST'] . ".</p>";

//Börja adda lite session
if (isset($_SESSION["user"])) {
    print("<p>Du är inloggad som " . $_SESSION["user"] . "</p>");
    print "<p>Du kommer ifrån: " . $_SERVER['REMOTE_ADDR'] . ".</p>";
    echo "<p>Om du inte exact vet vad allt detta betyder för just dig, oro dig inte, för det gör ingen annan heller.</p>";
} elseif (isset($_SESSION["admin"])) {
    print("<p><b>Välkommen Supreme " . $_SESSION["admin"] . ", här kommer extra data som gynnar dig!</b></p>");
    echo "<p>Följande version av PHP används: " . phpversion() . ".</p>";
    echo "<p>Följande version av Apache används: " . apache_get_version() . ".</p>";
    print("<p>Du är inloggad som " . $_SESSION["admin"] . "</p>");
    print "<p>Du kommer ifrån: " . $_SERVER['REMOTE_ADDR'] . ".</p>";

} else {
    print("<a href='session.php'>Logga in</a> om du vill se mer saker");
}
?>
</div>
</div>
</div>
</body>
</html>