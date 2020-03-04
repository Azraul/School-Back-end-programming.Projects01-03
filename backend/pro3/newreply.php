<?php
session_start();
$page = 'forum';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>
<h1>Reply</h1>
<div class="container leftborder">As a user you can reply to the post shown below with the form under the post.</div>
<?php
if (!isset($_GET['topic'])) {
    print('<div class="container leftborder">You must choose a topic to reply to first</div>');
}
if (isset($_SESSION['signed_in'])) {
    if ($_SESSION['user_level'] >= 0) {
        include 'connect.php';
        include 'testinput.php';
// Create connection
        $conn = new mysqli($server, $username, $password, $database);
        $conn->set_charset('utf-8');
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT *, users.user_name FROM topics INNER JOIN users ON topics.topic_by=users.user_id WHERE topic_id = " . $_GET['topic'];
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $datetime = new DateTime($row['topic_date']);
                print('<div class="container leftborder"><div class="start"><a href="category.php?id=' . $row['topic_cat'] . '&topic=' . $row['topic_id'] . '">' . $row['topic_subject'] . "</a><br>" . $row['topic_content'] . '</div><div class="end">By: <a href="user.php?id=' . $row['user_id'] . '">' . $row['user_name'] . '</a><br> time: ' . $datetime->format('H:i - d.m.Y') . "</div></div>");
                $topicID = $row['topic_id'];
            }
        } else {
            print('<div class="container leftborder">Topic dosen\'t exist, please try again.</div>');
        }
//Testar att göra newreply i newreply istället för en separat newreplyADD
        if (empty($_POST)) {
            echo '<form method="POST" action="">';
            echo '<input type="hidden" name="topic_id" value="' . $topicID . '"/>';
            echo '<span class="formName">Content: </span><textarea name="content" rows="5" cols="40" placeholder="Your content here"></textarea><br>';
            echo '<span class="formName">&nbsp;</span><input type="submit" name="post" value="Post"><br>';
            echo '</form>';
        } else {
//Hämta datan
            $post_topic = $_POST["topic_id"];
            $post_content = test_input($_POST["content"]);
            $post_content = str_replace("'",'&#8217;', $post_content);
            $post_creator = $_SESSION['user_id'];
//Blir ju inte med daylight savings
            $date = new Datetime();
            $date = $date->format('Y-m-d H:i:s');

            //Skapa posten
            $sql = "INSERT INTO posts (post_topic, post_content, post_date, post_by)
VALUES ('$post_topic', '$post_content', '$date', '$post_creator');";

            if ($conn->query($sql) === true) {
                echo '<div class="container leftborder">Reply added, taking you to the forums in 3 seconds!</div>';
                header('Refresh: 3; url=category.php?topic='.$post_topic);
            } else {
                echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
                echo '<div class="container leftborder">Please try again later</div>';
            }
        }
        //Stäng alltid
        $conn->close();
    }
} else {
    print('<div class="container leftborder">You must <a href="login.php");">login</a> first!</div>');
}
?>
<?php
include 'footer.php';
?>