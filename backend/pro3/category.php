<?php
session_start();
$page = 'forum';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';
//Inloggnings upggifterna
include 'engines.php';

//Om det finns id(cat) och topic
if (isset($_GET['id']) && isset($_GET['topic']) && !empty($_GET['topic']) && !empty($_GET['id'])) {
    showforum($_GET['id']);
    showtopic($_GET['topic']);
    showpostsBytopic($_GET['topic']);  
}
//Om det finns bara id (cat)
elseif (isset($_GET['id']) && !empty($_GET['id'])) {
    showforum($_GET['id']);
    showtopicsByforum($_GET['id']);
    if (isset($_SESSION['signed_in'])) {
        print('<div class="container cat_leftborder"><a class="topicbutton" href="newtopic.php?cat='.$_GET['id'].'">New topic</a></div>');
    }
}
//Om det finns bara topic
elseif (isset($_GET['topic']) && !empty($_GET['topic'])) {
    showforumBytopic($_GET['topic']);
    showtopic($_GET['topic']);
    showpostsBytopic($_GET['topic']);    
}
//Om inget id eller topic finns ska den printa alla forum
else {
    showALLforums();
    if (isset($_SESSION['signed_in']) && $_SESSION['user_level'] > 0) {
        print('<div class="container"><a class="modbtn" href="newforum.php">Make a new forum!</a></div>');
    }
}
?>

<?php
include 'footer.php';
?>