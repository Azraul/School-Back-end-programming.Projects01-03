<?php
session_start();
$page = 'forum';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>
<h1>Edit your topic</h1>
<div class="container leftborder">As a user you can edit your own topic. Just change the form and hit submit.
<br>Changing what forum the topic is posted to is unavailable.</div>
<?php
if (!isset($_GET['topic'])) {
    print('<div class="container leftborder">You must choose a topic to edit first</div>');
} else {
    if (isset($_SESSION['signed_in'])) {
        include 'connect.php';
        include 'testinput.php';
        // Create connection
        $conn = new mysqli($server, $username, $password, $database);
        $conn->set_charset('utf-8');
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            if (!empty($_POST)) {
                //Hämta datan från postad form
                $topic = test_input($_GET['topic']);
                $topic_name = test_input($_POST["title"]);
                $topic_content = test_input($_POST["content"]);
                $topic_content = str_replace("'",'&#8217;', $topic_content);
                //Kolla om topicen redan finns
                $sql = "SELECT topic_id, topic_by FROM topics WHERE topic_id = " . $topic;
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                if ($row['topic_by'] == $_SESSION['user_id']) {
                    $sql = "UPDATE topics SET topic_subject='$topic_name', topic_content='$topic_content' WHERE topic_id= " . $_GET['topic'];
                    $result = $conn->query($sql);
                    if ($conn->affected_rows > 0) {
                        print('<div class="container leftborder">You updated the topic! Taking you back to the topic</div>');
                        header('Refresh:2; url=category.php?topic='.$_GET['topic']);
                    }
                } else {
                    print('<div class="container leftborder">Something went wrong, try again later or perhaps the topic has been deleted.<div>');
                }
            } else {
                $topic = test_input($_GET['topic']);
                $sql = "SELECT * FROM topics WHERE topic_id = " . $topic;
                $result = $conn->query($sql);
                //Så det bara är 1 topic som ska editas
                if ($result->num_rows == 1) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        if ($row['topic_by'] == $_SESSION['user_id']) {
                            print('<form method="post" action="">');
                            print('<span class="formName">Topic Title: </span><input type="text" name="title" value="' . $row['topic_subject'] . '"><br>');
                            print('<span class="formName">Content: </span><textarea name="content" rows="5" cols="40" ">' . $row['topic_content'] . '</textarea><br>');
                            print('<span class="formName">&nbsp;</span><input type="submit" name="post" value="Edit"><br></form>');
                            //Kolla om det finns post data och updatera topicen om det finns
                        } else {
                            print('<div class="container leftborder">You are not the creator of this topic</div>');
                        }
                    }
                } else {
                    print('<div class="container leftborder">Nothing to return. Try again later or perhaps the topic has been deleted</div>');
                }
            }
            $conn->close();
        }
    }
}
?>

<?php
include 'footer.php';
?>