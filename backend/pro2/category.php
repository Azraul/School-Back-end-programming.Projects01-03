<?php
session_start();
$page = 'forum';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';
//Inloggnings upggifterna
include 'connect.php';

// Create connection
$conn = new mysqli($server, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Om inget id eller topic finns ska den printa alla forum
if (empty($_GET['id']) && empty($_GET['topic'])) {
    //Inget id, välj ett forum
    //Inloggnings upggifterna
    include 'connect.php';
    // Create connection
    $conn = new mysqli($server, $username, $password, $database);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM categories";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            print('<a class="forumcategory" href="category.php?id=' . $row['cat_id'] . '"><h3>' . $row['cat_name'] . '</h3><span class="plain">' . $row['cat_description'] . "</span></a>");
        }
    } else {
        print('<div class="container leftborder">Nothing here, try again later</div>');
    }
    if (isset($_SESSION['signed_in']) && $_SESSION['user_level']>0) {
        print('<div class="container"><a class="modbtn" href="newforum.php">Make a new forum!</a></div>');
    }
    //Stäng alltid annars får du minus poäng
    $conn->close();
}
//Börja med att printa vilket forum du är på
else {
    //Hämta forumet direkt från id
    if (isset($_GET['id'])) {
        $sql = "SELECT * FROM categories WHERE cat_id = " . $_GET['id'];
    }
    //Gör all komplicerat och hämta forumets id från topic_category
    elseif (isset($_GET['topic'])) {
        $sql = "SELECT topics.topic_cat, topics.topic_id, categories.cat_id, categories.cat_name, categories.cat_description FROM topics INNER JOIN categories ON topics.topic_cat=categories.cat_id WHERE topic_id= " . $_GET['topic'];
    }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            print('<h3>' . $row['cat_name'] . ' Forum</h3><span class="plain">' . $row['cat_description'] . "</span></a>");
        }
    } else {
        print('<div class="container leftborder">Something is wrong with this forum or it might not exist, try again later.</div>');
    }
    //Om inget topic är valt, printa alla topics i det forumet
    if (empty($_GET['topic'])) {
        //Them rows, JOINa lite, det va trevligt!
        $sql = "SELECT topics.topic_id, topics.topic_subject, topic_cat, topics.topic_date, users.user_name, topics.topic_content, users.user_id FROM topics INNER JOIN users ON topics.topic_by=users.user_id WHERE topic_cat = " . $_GET['id'];
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            //output time -- För alla topics
            while ($row = $result->fetch_assoc()) {
                $datetime = new DateTime($row['topic_date']);
                print('<div class="container leftborder"><div class="start"><a href="category.php?id=' . $row['topic_cat'] . '&topic=' . $row['topic_id'] . '">' . $row['topic_subject'] . "</a><br>" . $row['topic_content'] . '</div><div class="end">By: <a href="user.php?id=' . $row['user_id'] . '">' . $row['user_name'] . '</a><br> time: ' . $datetime->format('H:i - d.m.Y') . "</div></div>");
            }
        } else {
            print('<div class="container leftborder">Nothing here, try again later or perhaps make a <a href="newtopic.php?cat=' . $_GET['id'] . '"> new topic</a>.</div>');
        }
        if (isset($_SESSION['signed_in'])) {
            print('<div class="container"><a class="modbtn" href="newtopic.php?cat=' . $_GET['id'] . '">Make new topic</a></div>');
        }
    }
    //Om en topic är vald, dags att printa den
    else {
        $sql = "SELECT *, users.user_name FROM topics INNER JOIN users ON topics.topic_by=users.user_id WHERE topic_id = " . $_GET['topic'];
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $datetime = new DateTime($row['topic_date']);
                print('<div class="container leftborder"><div class="start"><a href="category.php?id=' . $row['topic_cat'] . '&topic=' . $row['topic_id'] . '">' . $row['topic_subject'] . "</a><br>" . $row['topic_content'] . '</div><div class="end">By: <a href="user.php?id=' . $row['user_id'] . '">' . $row['user_name'] . '</a><br> time: ' . $datetime->format('H:i - d.m.Y') . "</div>");
                if (isset($_SESSION['signed_in'])) {
                    print('<div class="clear"></div><div class="start">');
                    print('<a class="topicbutton" href="newreply.php?topic=' . $row['topic_id'] . '">Reply</a>');
                    if ($row['user_id'] == $_SESSION['user_id']) {
                        print('<a class="topicbutton" href="edittopic.php?topic=' . $row['topic_id'] . '">Edit</a>');
                        print('<a class="topicbutton" href="deletetopic.php?topic=' . $row['topic_id'] . '">Delete</a>');
                    }
                    print('</div>');
                }
                print('</div>');
            }
        } else {
            print("Topic dosen't exist");
        }
        $sql = "SELECT *, users.user_name FROM posts INNER JOIN users ON posts.post_by=users.user_id WHERE post_topic = " . $_GET['topic'];
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $datetime = new DateTime($row['post_date']);
                print('<div class="replycontainer"><div class="start">' . $row['post_content'] . "<br>" . '</div><div class="end">By: <a href="user.php?id=' . $row['user_id'] . '">' . $row['user_name'] . '</a><br> time: ' . $datetime->format('H:i - d.m.Y') . "</div>");
                if (isset($_SESSION['signed_in']) && $row['user_id'] == $_SESSION['user_id']) {
                    print('<div class="clear"></div><div class="start">');
                    print('<a class="topicbutton" href="editpost.php?post=' . $row['post_id'] . '">Edit</a>');
                    print('<a class="topicbutton" href="deletepost.php?post=' . $row['post_id'] . '">Delete</a>');
                    print('</div>');
                }
                print('</div>');
            }
        }
    }
    $conn->close();
}
//Stäng alltid annars får du minus poäng
?>

<?php
include 'footer.php';
?>