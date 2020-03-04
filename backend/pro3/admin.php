<?php
session_start();
$page = 'admin';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';
?>
<?php
//Quick fix, was apperently missing
include 'testinput.php';
function create_conn()
{
    //CURRENTLY NOT THE LIVE DATABASE
    //connection to database function
    $server = 'localhost';
    $username   = 'kuvajaan';
    $password   = 'GCWLLaCS6w';
    $database   = 'kuvajaan';
    $conn = new mysqli($server, $username, $password, $database);
    $conn->set_charset('utf-8');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        print('<div class="container leftborder">Problem connecting to our database, please try searching later</div>');
    }
    return $conn;
}
//All in i en if så man säkert är en admin kappa
if ((isset($_SESSION['signed_in'])) && ($_SESSION['user_level'] > 1)) {
//Ett par booleans som håller koll på vad man vill söka
    //Sen skitsnygg inline php i formen eftersom jag inte ville printa den med php eftersom jag gjort det redan
    $forumengine = false;
    $topicengine = false;
    $postengine = false;
    $userengine = false;
    $failed = false;
    $search = "";
//Sen kollar vi om vi har en search på gång och sätter sen switchen därefter
    if (isset($_POST['seek'])) {
        if (empty($_POST['string'])) {
            $search = "";
        } else {
            $search = $_POST['string'];
        }
        if (empty($_POST['field'])) {
            $field = "";
        } else {
            $field = $_POST['field'];
        }
        //Sätt breaks
        switch ($field) {
            case "forums":
                $forumengine = true;
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
                $failed = true;
        }
    }
    echo '<h1>Welcome Admin ' . $_SESSION['user_name'] . '</h1>';
    echo '<div class="container leftborder">With the power of admin you can delete posts, topics, forums and users</div>';
    echo '<form method="POST" action="admin.php">';
    echo '<span class="formName">Type: </span><select name="field">';
    echo '<option value="forums">Forums</option>';
    echo '<option value="topics">Topics</option>';
    echo '<option value="posts">Posts</option>';
    echo '<option value="users">Users</option>';
    echo '</select><br>';
    echo '<span class="formName">Search: </span><input type="text" name="string" value="' . $search . '" placeholder=""><br>';
    echo '<span class="formName">&nbsp;</span><input type="submit" name="seek" value="Search"></form>';

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
    if ($forumengine == true) {
        $search = test_input($search);
        //Search alla forums/categories med texten
        $sql = "SELECT * FROM categories WHERE cat_name LIKE '%$search%' ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            print('<div class="admintip">All forums found below!</div>');
            while ($row = $result->fetch_assoc()) {
                //h3 spökar måste ha extra clear
                print('<div class"container leftborder"><h3>' . $row['cat_name'] . ' Forum</h3><span class="plain">' . $row['cat_description'] . '</span>');
                print('<div class="clear"></div><div class="start"><a class="modbtn" href="deletecategorie.php?id=' . $row['cat_id'] . '">Delete forum</a></div></div><div class="clear"></div>');
            }
        } else {
            print('<div class="admintip">No forums found!</div>');
        }
    }
    if ($topicengine == true) {
        $search = test_input($search);
        //Search med all topics some har search texten
        $sql = "SELECT topics.topic_id, topics.topic_subject, topic_cat, topics.topic_date, users.user_name, topics.topic_content, users.user_id FROM topics INNER JOIN users ON topic_by=user_id WHERE topic_content LIKE '%$search%' OR topic_subject LIKE '%$search%' ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            print('<div class="admintip">All topics found below!</div>');
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $datetime = new DateTime($row['topic_date']);
                print('<div class="container leftborder"><div class="start"><a href="category.php?id=' . $row['topic_cat'] . '&topic=' . $row['topic_id'] . '">' . $row['topic_subject'] . "</a><br>" . $row['topic_content'] . '</div><div class="end">By: <a href="user.php?id=' . $row['user_id'] . '">' . $row['user_name'] . '</a><br> time: ' . $datetime->format('H:i - d.m.Y') . "</div>");
                print('<div class="clear"></div><div class="start">');
                print('<a class="modbtn" href="deletetopic.php?topic=' . $row['topic_id'] . '">Remove this topic</a>');
                print('</div></div>');
            }
        } else {
            print('<div class="admintip">No topics found!</div>');
        }
    }
    if ($postengine == true) {
        $search = test_input($search);
        //Search med all posts some har search texten
        $sql = "SELECT *, users.user_name FROM posts INNER JOIN users ON posts.post_by=users.user_id WHERE post_content LIKE '%$search%' ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            print('<div class="admintip">All posts found below!</div>');
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $datetime = new DateTime($row['post_date']);
                print('<div class="replycontainer"><div class="start">' . $row['post_content'] . "<br>" . '</div><div class="end">By: <a href="user.php?id=' . $row['user_id'] . '">' . $row['user_name'] . '</a><br> time: ' . $datetime->format('H:i - d.m.Y') . "</div>");
                print('<div class="clear"></div><div class="Start"><a class="modbtn" href="deletepost.php?post=' . $row['post_id'] . '">Remove this post</a></div></div>');
            }
        } else {
            print('<div class="admintip">No posts found!</div>');
        }
    }
    if ($userengine == true) {
        $search = test_input($search);
        //Search users
        $sql = "SELECT * FROM users WHERE users.user_name LIKE '%$search%' ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            print('<div class="admintip">All users found below!</div>');
            while ($row = $result->fetch_assoc()) {
                print('<div class="container leftborder"><div class="start"><a href="user.php?id=' . $row['user_id'] . '">' . $row['user_name'] . "</a><br>" . $row['user_email'] . '</div><div class="end">Joined: ' . $row['user_date'] . '<br> visits: ' . $row['user_visits'] . "</div>");
                print('<div class="clear"></div><div class="start"><a class="modbtn" href="useremail.php?id=' . $row['user_id'] . '">Change user email</a></div></div>');
            }
        } else {
            print('<div class="admintip">No users by <b>' . $search . '</b> found!</div>');
        }
    }
    if ($failed == true){
        print('<div class="admintip">Your search failed, try again later</div>');
    }
//stänger alltid
    $conn->close();
} else {
    print('<div class="container leftborder">You must <a href="login.php");">login</a> and prove that you are an admin!</div>');
    header("Refresh:3; url=login.php");
}
?>
<?php
include 'footer.php';
