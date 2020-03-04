<a <?php echo ($page == 'index') ? "class='activeNav'" : ""; ?> href="index.php">Hem</a>
<a <?php echo ($page == 'datum') ? "class='activeNav'" : ""; ?> href="datum.php">Datum räknare</a>
<a <?php echo ($page == 'epost') ? "class='activeNav'" : ""; ?> href="epost.php">Epost skickare</a>
<a <?php echo ($page == 'logg') ? "class='activeNav'" : ""; ?> href="logg.php">Gästbok</a>
<a <?php echo ($page == 'filer') ? "class='activeNav'" : ""; ?> href="filer.php">Fil uppladdare</a>
<a <?php echo ($page == 'rapport') ? "class='activeNav'" : ""; ?> href="rapport.php">Rapport</a>
<?php
//Logga in eller logga ut och en logga ut confirm för man tryckte ju fel 3 gånger i rad och blev lite irriterad :D
if (isset($_SESSION["user"]) or isset($_SESSION["admin"])){
    echo '<a ';
    echo ($page == 'galleri') ? "class='activeNav'" : "";
    echo 'href="galleri.php">Galleri</a>';
    echo '<span id="LOGGA_UT"><a href="sessionEnd.php" onclick="return confirm(\'Du är på väg att logga ut\')">Logga ut</a></span>';

} else {
    echo '<a ';
    echo ($page == 'session') ? "class='activeNav'" : "";
    echo 'href="session.php">Logga in</a>';
}
if (isset($_SESSION["admin"])){
    echo '<a ';
    echo ($page == 'admin') ? "class='activeNav'" : "";
    echo 'href="admin.php" onclick="return confirm(\'Du är påväg till Admin sidan!\')">Admin</a>';
}
//Dynamisk activeNav funkade!!!
?>
<!--- Påmin mig att göra en separat php för globalNav -->
<span id="globalNav">
<a href="../home">Start</a>
<a class='activeNav' href="../pro1">Projekt 1</a>
<a href="../pro2">Projekt 2</a>
<a href="../pro3">Projekt 3</a>
<span>