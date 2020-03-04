<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Kristoffers PHP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
    <style>
.error {color: #FF0000;}
</style>
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
<?php

//Från w3.schools med modifikationer

//Gjorde ha en commentErr eftersom sida ska ha en hälsning
$nameErr = $emailErr = $commentErr = "";
$name = $_POST["name"];
$email =$_POST["email"];
$comment = $_POST["comment"];

//Boolean för att kolla om vi ska göra kommentaren eller inte annars postar sidan såfort den refreshar
$postKomment = true;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
        $postKomment = false;
    } else {
        $name = test_input($_POST["name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
            $postKomment = false;
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $postKomment = false;
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $postKomment = false;
        }
    }

    if (empty($_POST["comment"])) {
        $commentErr = "Hälsning behövs";
        $postKomment = false;
    } else {
        $comment = test_input($_POST["comment"]);
        //Kollar att min comments inte blir haxxade eftersom .html
        if (!preg_match("/^[a-zA-ZåäöÅÄÖ 0-9 \"'!&()@[\]\?.:,;\-_]*$/u", $comment)) {
            $commentErr = "Bara bokstäver, siffror och mellanslag";
            $postKomment = false;
        }
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!--- Snyggt med dynamiska error messages; formen modifierade från w3 --->

<h1>Gästbok</h1>
<form method="post" action="kommentar.php" method="POST">
<span class="formName">Namn: </span><input type="text" name="name" value="" placeholder="Lenny">
  <span class="error"><?php echo $nameErr; ?></span>
  <br><br>
  <span class="formName">Epost: </span><input type="text" name="email" value="" placeholder="förnamn.efternamn@arcada.fi">
  <span class="error"><?php echo $emailErr; ?></span>
  <br><br>
  <span class="formName">Hälsning: </span><textarea name="comment" rows="5" cols="40" placeholder="( ͡° ͜ʖ ͡°)"></textarea>
  <span class="error"><?php echo $commentErr; ?></span>
  <br><br>
  <span class="formName">&nbsp;</span><input type="submit" name="submit" value="Submit">
</form>

<?php
if ($postKomment == true) {

    //Tiden och kommentaren
    $dateTimeServer = new DateTime();
    $kommentarenTxt = "<b>Namn: </b>" . $name . "<br>" .
        "<b>Epost: </b>" . $email . "<br>" .
        "<b>Kommentar: </b>" . $comment . "<br>".
        "<b>Klockan: </b>" .$dateTimeServer->format('H:i:s Y-m-d')  . "<hr>";
    //Öppna med handler
    $handler = fopen("kommentarer.html", "a+") or die("Filen gick inte att öppna");

    //Så att kommentaren alltid kommer överst, kommer bli sämre ju större filen blir eftersom den skriver om hela tiden!
    $kommentarFilen = $kommentarenTxt . "\n";
    $kommentarFilen .= file_get_contents('kommentarer.html');
    file_put_contents('kommentarer.html', $kommentarFilen);
    //Stänga filen
    fclose($handler);
}
?>
<section class="kommentarer">
<?php include 'kommentarer.html';?>
</section>
</div>
</div>
</div>
</body>
</html>