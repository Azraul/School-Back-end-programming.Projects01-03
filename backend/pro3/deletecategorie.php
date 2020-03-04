<?php
session_start();
$page = 'admin';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>
<h1>Delete the forum</h1>
<div class="container leftborder">As admin you can delete a forum, all it's topics and posts, wield your power carefully</div>
<?php
if (!isset($_GET['id'])) {
    print('<div class="container leftborder">You must choose a forum to delete first</div>');
} else {
    if (isset($_SESSION['signed_in']) && $_SESSION['user_id']>1) {
        include 'connect.php';
        // Create connection
        $conn = new mysqli($server, $username, $password, $database);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            if (!empty($_POST)) {
                if ($_SESSION['user_level']>1) {
                    $sql = "DELETE FROM categories WHERE cat_id= " . $_GET['id'];
                    $result = $conn->query($sql);
                    if ($conn->affected_rows > 0) {
                        print('<div class="admintip">You deleted the foum, returning you to the forums.</div>');
                        header('Refresh:2; url=category.php?');
                    }
                } else {
                    print('<div class="admintip">Something went wrong on the deletion</div>');
                }
            } else {
                $sql = "SELECT * FROM categories WHERE cat_id = " . $_GET['id'];
                $result = $conn->query($sql);
                if ($result->num_rows == 1) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        if (($_SESSION['user_level']>1)) {
                            print('<form method="post" action="">');
                            print('<span class="formName">Forum: </span><input type="text" readonly="readonly" value="' . $row['cat_name'] . '"></input><br>');
                            print('<span class="formName">&nbsp;</span><input type="submit" name="post" value="Delete" onclick="return confirm(\'Are you sure you want to permanently delete this forum and all associated topics and posts?\');"><br></form>');
                            //Kolla om det finns post data och updatera topicen om det finns
                        } else {
                            print('<div class="container leftborder">You are not an admin</div>');
                        }
                    }
                } else {
                    print('<div class="container leftborder">Nothing to return. Try again later.</div>');
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