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
    <?php $page = 'epost'; include 'meny.php';?>
    <?php include 'besokare.php';?>
    </div>
    <div id="bakgrundHome"></div>
    <div id="mainFrame">
        <div class="mainContent">
            <div class="pageTitle">
                <h1>Epost</h1>
    <form method="post" action="epostSkicka.php">
    <span class="formName">Namn: </span><input type="text" name="name" value="" placeholder="Lenny">
  <br><br>
  <span class="formName">Epost: </span><input type="text" name="email" value="" placeholder="förnamn.efternamn@arcada.fi">
  <br><br>
  <span class="formName">&nbsp;</span><input type="submit" name="submit" value="Submit">
</form>
</div>
</div>
</div>
</body>
</html>