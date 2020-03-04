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
    <?php $page = 'datum'; include 'meny.php';?>
    <?php include 'besokare.php';?>
    </div>
    <div id="bakgrundHome"></div>
    <div id="mainFrame">
        <div class="mainContent">
            <div class="pageTitle">
                <h1>Datum Kalkylator</h1>

        
           
        
      
        <form action="datumKalkylera.php" method="get">
        <span class="formName">Dag:</span><input type="text" name="day" placeholder="dag"><br>
        <span class="formName">Månad:</span><input type="text" name="month" placeholder="månad"><br>
        <span class="formName">År:</span><input type="text" name="year" placeholder="år"><br>
        <span class="formName">&nbsp;</span><input type="submit" name="skicka" value="Kalkylera">
        </form>
</div>
</div>
</div>
</body>
</html>