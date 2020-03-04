<?php
session_start();
$page = 'forum';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>
<h1>Delete your topic</h1>
<div class="container leftborder">As a user you can delete your own topic and all posts associated with the topic.</div>
<?php
if (!isset($_GET['topic'])) {
    print('<div class="container leftborder">You must choose a topic to delete first</div>');
} else {
    if (isset($_SESSION['signed_in'])) {
        include 'connect.php';
        // Create connection
        $conn = new mysqli($server, $username, $password, $database);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            if (!empty($_POST)) {
                $sql = "SELECT topic_id, topic_by FROM topics WHERE topic_id = " . $_GET['topic'];
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                //Insane relationship, delete topic = delete attached posts!
                //Använde mig av ADD FOREIGN KEY i databasen
                //Guide här: https://code.tutsplus.com/tutorials/how-to-create-a-phpmysql-powered-forum-from-scratch--net-10188
                if (($row['topic_by'] == $_SESSION['user_id']) || $_SESSION['user_level']>1) {
                    $sql = "DELETE FROM topics WHERE topic_id= " . $_GET['topic'];
                    $result = $conn->query($sql);
                    if ($conn->affected_rows > 0) {
                        print('<div class="container leftborder">You deleted the topic, returning you to the forums!</div>');
                        header('Refresh:2; url=category.php?');
                    }
                } else {
                    print('<div class="container leftborder">Something went wrong, try again later or perhaps the topic has been deleted.</div>');
                }
            } else {
                $sql = "SELECT * FROM topics WHERE topic_id = " . $_GET['topic'];
                $result = $conn->query($sql);
                //Så det bara är 1 topic som ska editas
                if ($result->num_rows == 1) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        if (($row['topic_by'] == $_SESSION['user_id']) || $_SESSION['user_level']>1) {
                            print('<form method="post" action="">');
                            print('<span class="formName">Topic Title: </span><input type="text" name="title" value="' . $row['topic_subject'] . '" readonly="readonly" ><br>');
                            print('<span class="formName">Content: </span><textarea name="content" rows="5" cols="40"  readonly="readonly" >' . $row['topic_content'] . '</textarea><br>');
                            print('<span class="formName">&nbsp;</span><input type="submit" name="post" value="Delete" onclick="return confirm(\'Are you sure you want to permanently delete this topic and all posts?\');"><br></form>');
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
    } else {
        print('<div class="container leftborder">You must <a href="login.php");">login</a> first!</div>');
    }
}
?>

<?php
include 'footer.php';
?>