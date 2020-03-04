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

    <?php
// define variables and set to empty values
$nameErr = $emailErr = "";

//Kan kolla om nameErr och emailErr == ""; Men 1 till variable skall väl inte kosta så mycket
$forwardMail = true;

//Hämta datan
$name = $_POST['name'];
$email = $_POST['email'];

//Fina w3schools igen med forwardMail inne
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
        $forwardMail = false;
    } else {
        $name = test_input($_POST["name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
            $forwardMail = false;
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $forwardMail = false;
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $forwardMail = false;
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

//Stackoverflow - Gör en array, slå ihop arrayen till en string, returna stringen
function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}

//Dags att skicka mail då och göra ett random lösenord
if ($forwardMail == true) {
    $losenord = randomPassword();
    $to = $email;
    $subject = 'the subject';
    $message = 'Hej kära ' . $name . "\r\n Här kommer ditt lösenord: " . $losenord. "\r\n Tack för att du använde kuv-service.";
    $headers = 'From: admin@kuv.com' . "\r\n" .
    'Do not reply-To: admin@kuv.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

    echo "<p>Ett mail har skickats till den angivna adressen med ett hemligt lösenord!</p>";
    echo "<p>Tack för att du använde kuv services!</p>";
}
?>

<h2>PHP Form Validation Example</h2>
<form method="post" action="epostSkicka.php">
<span class="formName">Namn: </span><input type="text" name="name" value="<?php echo $name; ?>"  placeholder="Lenny">
  <span class="error"><?php echo $nameErr; ?></span>
  <br><br>
  <span class="formName">Epost: </span><input type="text" name="email" value="<?php echo $email; ?>"  placeholder="förnamn.efternamn@arcada.fi">
  <span class="error"><?php echo $emailErr; ?></span>
  <br><br>
  <span class="formName">&nbsp;</span><input type="submit" name="submit" value="Submit">
</form>
</div>
</div>
</div>
</body>
</html>