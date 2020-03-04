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
    <?php $page = 'rapport';include 'meny.php';?>
    <?php include 'besokare.php';?>
    </div>
    <div id="bakgrundHome"></div>
    <div id="mainFrame">
        <div class="mainContent">
            <div class="pageTitle">
                <h1>Rapport</h1>
                <h2>Projekt 1 - PHP</h2>
                            <h3>PHP programmering och syntax</h3>
                            Samtliga uppgifter utfördes i Visual Studio Code med hjälp av W3.schools.com, stackoverflow, och Arcadas lärande och handledande. Alla dokument är kommenterade för enklare läsning.
                            <h4>Uppgifter</h4>
                            <p>Alla uppgifter borde vara gjorda till 100%, besökarantal finns upp i hörnet och inloggade user:n pleb har extra menyer som endast visar innehåll på sidan om de är inloggade samt ännu en extra sida för admin profilen. Datan på index.php är också mer och mindre utförlig beroende på session/user.<br>
                            Filer kan också endast laddas upp av en inloggade användare.<br>
                            Saker som kunde gjorts bättre är att använda redirects, t.ex. när man laddat upp något så kommer en ”confirm” sida och sedan efter 2-3 sekunder kommer man tillbaka till sidan man var vid innan.</p>
                            <p>Dessutom fanns det ett flertal funktioner där flera rekommendationer talade om att använda AJAX vilket gör att jag tror, med hänsyn till läroplan/ledning, att frontend och backend skulle kunna kombinera saker för att gynna eleven om läraren handleder i momenten dock kan jag förstå svårigheten i det när kurserna går separat</p>
                            <p>Sen i mitt bildgalleri, om man har väldigt långa namn på sina bilder kommer det utanför rutan. Realistiskt skulle jag såklart gjort finare galleri med jQuery och lightboxes men nu var det ju inte det kursen handlade om och tiden hår fått ticka länge nog.</p>
                            <p><b>Update efter inlämning 04 Feb:</b> Ser ut som min "besökare sen" (uppe i hörnet med filem-|filectime) inte funkade som jag ville, borde skrivit creation date i filen och printat det.</p>
                            <h4>Reflektioner</h4>
                            <p>Under denna period har vi jobbat kodat en hel del, trots ibland många avbrott och ”recaps”, tittar på dig lektion 4, har väldigt mycket av projektet varit färdigt med bara lektionstillfällen. Det har varit förvånande att se hur lite engagemang elever haft för kursen då läxor sällan gjorts av majoriteten, dock saknas de i itslearning och kommer bara som en rad text i en .pdf under backend vilket kan medföra att man glömmer/ignorerar läxan.<br>
                            Att vi har kodat mycket har gjort det väldigt enkelt att följa med, projekt 1 kändes enkelt men som tur fanns det extra utmaningar att ta för sig om man så önskade. Egna mål jag uppnått var dynamiska klasser för min navbar, lite regex valideringar och hemliga menyer med sessions.</p>
                            <p>Skulle gärna gå in mer på session, antar också att vi kommer göra det då de flesta online guider tar de i samarbete med MySQL vilket kommer senare under kursen. Projektet var bra, men jag undrar själv om man borde ha skippat session delen till MySQL helt och hållet, kanske där finns något man kunde gjort nu istället?<br>
                            Som extra notis skulle jag nog säga att en jQuery uppgift i kombination med PHP skulle varit väldigt nyttigt då man skulle fått kombinera frontend och backend.</p>
                    <p class="signature">Kristoffer Kuvaja Adolfsson 03 Februari 2019</p>
                </article>
</div>
</div>
</div>
</body>
</html>