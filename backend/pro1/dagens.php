<?php

/********* Uppgift 2 ********************
 **** Säger dagens datum i **************
 **** språkvänlig finska ****************
 **** Samt vilken vecka det är **********
 ****************************************/

//wday gav error under söndagen när jag hade -1 men när jag hade -1 visade den trots det lördag under lördagen men error under söndagen

$veckodagar = array("söndag", "måndag", "tisdag", "onsdag", "torsdag", "fredag", "lördag");
$månader = array("januari", "februari", "mars", "april", "maj", "juni", "juli", "augusti", "september", "oktober", "november", "december");
$idag = getdate();
$svenskveckodag = $veckodagar[$idag['wday']];
$svenskmånad = $månader[$idag['mon'] - 1];
$vecka = ceil($idag['yday'] / 7);
print("<p>Idag är det " . $svenskveckodag . "en den " . $idag['mday'] . " " . $svenskmånad . " " . $idag['year'] . " och det är vecka " . $vecka . ".</p>");

?>