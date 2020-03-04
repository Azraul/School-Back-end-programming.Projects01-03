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
    <?php $page = 'logg'; include 'meny.php';?>
    <?php include 'besokare.php';?>
    </div>
    <div id="bakgrundHome"></div>
    <div id="mainFrame">
        <div class="mainContent">
            <div class="pageTitle">
            <h1>Gästbok</h1>
<form method="post" action="kommentar.php" method="POST">
<span class="formName">Namn: </span><input type="text" name="name" value="" placeholder="Lenny">
  <br><br>
  <span class="formName">Epost: </span><input type="text" name="email" value="" placeholder="förnamn.efternamn@arcada.fi">
  <br><br>
  <span class="formName">Hälsning: </span><textarea name="comment" rows="5" cols="40" placeholder="( ͡° ͜ʖ ͡°)"></textarea>
  <br><br>
  <span class="formName">&nbsp;</span><input type="submit" name="submit" value="Submit">

</form>
<section class="kommentarer">
<?php include 'kommentarer.html';?>
</section>
</div>
</div>
</div>
</body>
</html>