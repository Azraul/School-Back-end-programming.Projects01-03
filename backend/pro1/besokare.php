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
<!--- Ett dokument som bör includas med php överallt där man vill hålla kolla på hur många användare som kommit till sidan --->
<?php

if (isset($_SESSION["user"]) or isset($_SESSION["admin"]) or isset($_SESSION["guest"])){
    $handler = fopen("besok.log", "a+") or die("Filen gick inte att öppna");
    $variable_from_file = (int)file_get_contents('besok.log');
    //Antal besökare sen filen skapades
    echo "<span id=besokare>".$variable_from_file." besökare sen ". date("F d Y H:i:s.", filectime('besok.log'))."</span>";
    fclose($handler);

} else {
    $_SESSION["guest"] = "guest";
    $handler = fopen("besok.log", "a+") or die("Filen gick inte att öppna");
    $variable_from_file = (int)file_get_contents('besok.log');
    if ($variable_from_file == null) {
        $variable_from_file = 1;
    }
    else {
        $variable_from_file++;
    }
    file_put_contents('besok.log', $variable_from_file);
    //Antal besökare sen filen skapades
    echo "<span id=besokare>".$variable_from_file." besökare sen ". date("F d Y H:i:s.", filectime('besok.log'))."</span>";
    fclose($handler);
}
?>
</body>
</html>