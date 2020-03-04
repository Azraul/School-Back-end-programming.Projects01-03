<?php
session_start();
$page = 'forum';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>
<h1>Edit your post</h1>
<div class="container leftborder">As a user you can edit your own post. Just change the form and hit edit.</div>
<?php
if (!isset($_GET['post'])) {
    print('<div class="container leftborder">You must choose a post to edit first</div>');
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
                $post = test_input($_GET['post']);
                $post_content = test_input($_POST["content"]);
                $post_content = str_replace("'",'&#8217;', $post_content);
                //Kolla om topicen redan finns
                $sql = "SELECT post_id, post_by, post_topic FROM posts WHERE post_id = " . $post;
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $post_topic =$row['post_topic'];
                if ($row['post_by'] == $_SESSION['user_id']) {
                    $sql = "UPDATE posts SET post_content='$post_content' WHERE post_id= " . $post;
                    $result = $conn->query($sql);
                    if ($conn->affected_rows > 0) {
                        print('<div class="container leftborder">You updated the post, taking back to the topic!</div>');
                        header('Refresh:2; url=category.php?topic='.$post_topic);

                    }
                } else {
                    print('<div class"container leftborder">Something went wrong, try again later or perhaps the post or topic has been deleted.</div>');
                }
            } else {
                $post = test_input($_GET['post']);
                $sql = "SELECT * FROM posts WHERE post_id = " . $post;
                $result = $conn->query($sql);
                //Så det bara är 1 post som ska editas
                if ($result->num_rows == 1) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        if ($row['post_by'] == $_SESSION['user_id']) {
                            print('<form method="post" action="">');
                            print('<span class="formName">Content: </span><textarea name="content" rows="5" cols="40" >' . $row['post_content'] . '</textarea><br>');
                            print('<span class="formName">&nbsp;</span><input type="submit" name="post" value="Edit"><br></form>');
                            //Kolla om det finns post data och updatera topicen om det finns
                        } else {
                            print('<div class="container leftborder">You are not the creator of this post</div>');
                        }
                    }
                } else {
                    print('<div class"container leftborder">Nothing to return. Try again later or perhaps the post or topic has been deleted</div>');
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