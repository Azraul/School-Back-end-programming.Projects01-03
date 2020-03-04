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
<?php
$day = intval($_GET["day"]);
$month = intval($_GET["month"]);
$year = intval($_GET["year"]);

//Återskapar förra sidan så illusionen upplevs ännu starkare!!! Med sina inmatade datum kvar.
//Update/lärdom, skriv det i html och sätt in php taggarna där de behövs sen

echo '<div>
        <form action="datumKalkylera.php" method="get">
        <span class="formName">Dag:</span><input type="text" name="day" value="' . $day . '"><br>
        <span class="formName">Månad:</span><input type="text" name="month" value="' . $month . '"><br>
        <span class="formName">År:</span><input type="text" name="year" value="' . $year . '"><br>
        <span class="formName">&nbsp;</span><input type="submit" name="skicka" value="Kalkylera">
        </form>
</div>
    <h3>Jag har räknat ut:</h3>';

/********* Uppgift 3 ********************
 **** Efter att ha valt ett datum ***********
 **** använder jag DateTime       ***********
 **** för att kolla skillnaden    ***********
 ********************************************
 **** Tack till följande guide:
 **** https://web-techno.net/php-datetime-explained/
 ****
 ****************************************/

//Check om datumen är rimliga, DateTime är så bra att 31 februari blir 3 mars under vanliga år, otroligt!

if ($day > 0 and $day <= 31 and $month > 0 and $month <= 12 and $year > 0) {

//inmatat datum från datum.php
    $dateTimeUser = new DateTime($year . '-' . $month . '-' . $day);
    echo ("<p>Du valde: " . $dateTimeUser->format('Y-m-d H:i:s') . "</p>");

//serverns tid just när du kommer
    $dateTimeServer = new DateTime();
    echo ("<p>Nu är det: " . $dateTimeServer->format('Y-m-d H:i:s') . "</p>");

//Jämnför skillnaden mellan datumen, det var det här man använde DateTime för!
    $interval = $dateTimeServer->diff($dateTimeUser);

//Check som kollar att det stämmer
    //echo ("<p>".$interval->format('%Y-%m-%d %H:%i:%s')."</p>");

//Massor med checks så att vår string kan läsas i fin svenska.

    echo "<p>Det är ";
    if ($interval->y != 0) {
        echo ($interval->y . " år och ");
    }

    if ($interval->m == 1 or $interval->m == -1) {
        echo ($interval->m . " månad och ");
    } elseif ($interval->m != 0) {
        echo ($interval->m . " månader och ");
    }

    if ($interval->d == 1 or $interval->d == -1) {
        echo ($interval->d . " dag och ");
    } elseif ($interval->d != 0) {
        echo ($interval->d . " dagar och ");
    }

    if ($interval->h == 1 or $interval->h == -1) {
        echo ($interval->h . " timme och ");
    } elseif ($interval->h != 0) {
        echo ($interval->h . " timmar och ");
    }

    if ($interval->i == 1 or $interval->i == -1) {
        echo ($interval->i . " minut och ");
    } elseif ($interval->i != 0) {
        echo ($interval->i . " minuter och ");
    }

    echo $interval->s;

    echo " sekunder till det valda datumet som är i ";

//Räknare den datumet i framtiden eller i det förflutna
    if ($dateTimeServer > $dateTimeUser) {
        echo 'det förflutna';
    } else {
        echo 'framtiden';
    }
    echo "</p>";

//Sen såklart om man inte har ett riktigt datum, dessutom finns ju formen kvar ovan, bara fylla i den på nytt
} else {
    echo "Välj ett giltigt datum!";
}

/* Det vi gjorde på lektionen
//input validation ((Very basic))
if (($day > 31) or ($day <0)) {
echo("<p>Välj ett riktigt datum</p>");
}
else{
echo ("<p>Inmatade datumet är: " . $day . "." . $month . "." . $year .  ".<p>");
$timeNow = time();
print ($timeNow. " Tiden nu<br>");
$givenTime = mktime(0,0,0,$month,$day,$year);
print ("Där är ". $givenTime . " sekunder sedan Jan 1 1970.<br>");
print("Hur länge till " . $givenTime . " sekunder sedan Jan 1 1970<br>");
$differanceTime = $givenTime - $timeNow;
print ("Det är ".$differanceTime." tills din inmatade tid<br>");
$daysRemain = $differanceTime/(24*60*60);
$remaining = $differanceTime%(24*60*60);
$hoursRemain = $remaining/3600;

print("Det är ".floor($daysRemain) . " dagar och ".floor($hoursRemain) . " timmar till det angivna datumet.<br>");

}*/
?>
</div>
</div>
</div>
</body>
</html>