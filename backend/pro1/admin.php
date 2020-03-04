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
    <?php $page = 'admin';include 'meny.php';?>
    <?php include 'besokare.php';?>
    </div>
    <div id="bakgrundHome"></div>
    <div id="mainFrame">
        <div class="mainContent">
            <div class="pageTitle">
                <h1>Admin Sidan</h1>
        <?php
if (isset($_SESSION["admin"])) {
    echo "<p>Men massor med IPn, tasty!</p>";

    //Som vi gjorde på lektionen, men file() = läs dokumentet till en array så vi kan foreach på den
    $handler = fopen("besokIP.log", "r") or die("Unable to open file!");
    $innehall = file('besokIP.log');

    //Gör inkrimenteringen före, hjärngympa!
    $i = 0;
    foreach ($innehall as $line ){
                print("Besökare nummer ".++$i. ": ". $line . "<br>");
    }
    fclose($handler);
}
else {
    print("<a href='session.php'>Logga in</a>");
}

?>
</div>
</div>
</div>
</body>
</html>