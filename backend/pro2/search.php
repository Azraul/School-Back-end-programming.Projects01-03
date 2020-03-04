<?php
session_start();
$page = 'search';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>
<?php
//Ett par booleans som håller koll på vad man vill söka
//Sen skitsnygg inline php i formen eftersom jag inte ville printa den med php eftersom jag gjort det redan
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
        case "users":
            $userengine = true;
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
    <option value="users"<?php if ($userengine == true) {echo " selected ";}?>>By user name only</option>
</select><br>
<span class="formName">Search: </span><input type="text" name="string" value="<?php echo $search ?>" placeholder=""><br>
<span class="formName">&nbsp;</span><input type="submit" name="seek" value="Search">
</form>
<?php
//P.S det var snyggare med php form istället för inline php men nu har man sett det iallafall
//Logga in till databasen, kör den "search-engine" man frågat efter och sen stänga servern
include 'connect.php';
// Create connection
$conn = new mysqli($server, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    print('<div class="container leftborder">Problem connecting to our database, please try searching later</div>');
}
if ($topicengine == true) {
    //Search med all topics some har search texten
    $sql = "SELECT topics.topic_id, topics.topic_subject, topic_cat, topics.topic_date, users.user_name, topics.topic_content, users.user_id FROM topics INNER JOIN users ON topic_by=user_id WHERE topic_content LIKE '%$search%' OR topic_subject LIKE '%$search%' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $datetime = new DateTime($row['topic_date']);
            print('<div class="container leftborder"><div class="start"><a href="category.php?id=' . $row['topic_cat'] . '&topic=' . $row['topic_id'] . '">' . $row['topic_subject'] . "</a><br>" . $row['topic_content'] . '</div><div class="end">By: <a href="user.php?id=' . $row['user_id'] . '">' . $row['user_name'] . '</a><br> time: ' . $datetime->format('H:i - d.m.Y') . "</div></div>");
        }
    } else {
        print('<div class="container leftborder">No topics found!</div>');
    }
}
if ($postengine == true) {
    //Search med all posts some har search texten
    $sql = "SELECT *, users.user_name FROM posts INNER JOIN users ON posts.post_by=users.user_id WHERE post_content LIKE '%$search%' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $datetime = new DateTime($row['post_date']);
            print('<div class="replycontainer"><div class="start">' . $row['post_content'] . "<br>" . '</div><div class="end">By: <a href="user.php?id=' . $row['user_id'] . '">' . $row['user_name'] . '</a><br> time: ' . $datetime->format('H:i - d.m.Y') . "</div>");
            print('</div>');
        }
    } else {
        print('<div class="replycontainer">No posts found!</div>');
    }
}
if ($userengine == true) {
    //Search med all posts & topics av usern i search texten
    $sql = "SELECT topics.topic_by, topics.topic_cat, topics.topic_date,topics.topic_id,topics.topic_subject, topics.topic_content, users.user_id, users.user_name FROM (topics INNER JOIN users ON topics.topic_by=users.user_id) WHERE users.user_name = '$search' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $datetime = new DateTime($row['topic_date']);
            print('<div class="container leftborder"><div class="start"><a href="category.php?id=' . $row['topic_cat'] . '&topic=' . $row['topic_id'] . '">' . $row['topic_subject'] . "</a><br>" . $row['topic_content'] . '</div><div class="end">By: <a href="user.php?id=' . $row['user_id'] . '">' . $row['user_name'] . '</a><br> time: ' . $datetime->format('H:i - d.m.Y') . "</div></div>");
        }
    } else {
        print('<div class="container leftborder">No topics by user <b>'.$search.'</b> found!</div>');
    }
    //Posts delen
    $sql = "SELECT *, users.user_name FROM posts INNER JOIN users ON posts.post_by=users.user_id WHERE users.user_name = '$search' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $datetime = new DateTime($row['post_date']);
            print('<div class="replycontainer"><div class="start">' . $row['post_content'] . "<br>" . '</div><div class="end">By: <a href="user.php?id=' . $row['user_id'] . '">' . $row['user_name'] . '</a><br> time: ' . $datetime->format('H:i - d.m.Y') . "</div>");
            print('</div>');
        }
    } else {
        print('<div class="replycontainer">No posts by user <b>'.$search.'</b> found!</div>');
    }
}
//stänger alltid
$conn->close();
?>
<?php
include 'footer.php';
?>