<?php
session_start();
$page = 'search';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>
<?php
//Ett par booleans som håller koll på vad man vill söka
$topicengine = false;
$postengine = false;
$userengine = false;
$search = "";
//Sen kollar vi om vi har en search på gång och sätter sen switchen därefter
if (isset($_GET['seek'])) {
    if (empty($_GET['string'])) {
        $search = "";
    } else {
        $search = $_GET['string'];
    }
    if (empty($_GET['field'])) {
        $field = "";
    } else {
        $field = $_GET['field'];
    }
    //Sätt breaks
    switch ($field) {
        case "all":
            $topicengine = true;
            $postengine = true;
            break;
        case "topics":
            $topicengine = true;
            break;
        case "posts":
            $postengine = true;
            break;
        default:
            print('Your search failed, please try again');
    }
}
?>
<h1>Search</h1>
<div class="container leftborder">Search our forum topics and posts with the fields below</div>
<form method="GET" action="search.php">
<span class="formName">Type: </span><select name="field">
    <option value="all"<?php if ($topicengine == true && $postengine == true) {echo " selected ";}?>>Topics & Posts</option>
    <option value="topics"<?php if ($topicengine == true && $postengine == false) {echo " selected ";}?>>Topics only</option>
    <option value="posts"<?php if ($topicengine == false && $postengine == true) {echo " selected ";}?>>Posts only</option>
</select><br>
<span class="formName">Search: </span><input type="text" autocomplete="off" name="string" value="<?php echo $search ?>" placeholder="" onkeyup="suggest(this.value)"><br>
<span class="formName">&nbsp;</span><input type="submit" name="seek" value="Search">
</form>
<div id="livesearch"></div>

<?php

include 'engines.php';

if ($topicengine == true) {
    showtopics($search);

}
if ($postengine == true) {
    showposts($search);
}
?>
<?php
include 'footer.php';
?>