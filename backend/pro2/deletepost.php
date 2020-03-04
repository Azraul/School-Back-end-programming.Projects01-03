<?php
session_start();
$page = 'forum';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>
<h1>Edit your topic</h1>
<div class="container leftborder">As a user you can delete your own post.</div>
<?php
if (!isset($_GET['post'])) {
    print('<div class="container leftborder">You must choose a post to delete first</div>');
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
                $sql = "SELECT post_id, post_by FROM posts WHERE post_id = " . $_GET['post'];
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                if (($row['post_by'] == $_SESSION['user_id']) || $_SESSION['user_level']>1) {
                    $sql = "DELETE FROM posts WHERE post_id= " . $_GET['post'];
                    $result = $conn->query($sql);
                    if ($conn->affected_rows > 0) {
                        print('<div class="container leftborder">You deleted the post, returning you to the forum!</div>');
                        header('Refresh:2; url=category.php?');
                    }
                } else {
                    print('<div class="container leftborder">Something went wrong, try again later or perhaps the post or topic has been deleted.</div>');
                }
            } else {
                $sql = "SELECT * FROM posts WHERE post_id = " . $_GET['post'];
                $result = $conn->query($sql);
                if ($result->num_rows == 1) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        if (($row['post_by'] == $_SESSION['user_id']) || $_SESSION['user_level']>1) {
                            print('<form method="post" action="">');
                            print('<span class="formName">Content: </span><textarea name="content" rows="5" cols="40" readonly="readonly" >' . $row['post_content'] . '</textarea><br>');
                            print('<span class="formName">&nbsp;</span><input type="submit" name="post" value="Delete" onclick="return confirm(\'Are you sure you want to permanently delete this post?\');"><br></form>');
                            //Kolla om det finns post data och updatera topicen om det finns
                        } else {
                            print('<div class="container leftborder">You are not the creator of this post</div>');
                        }
                    }
                } else {
                    print('<div class="container leftborder">Nothing to return. Try again later or perhaps the post or topic has been deleted</div>');
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