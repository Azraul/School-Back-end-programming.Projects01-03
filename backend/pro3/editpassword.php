<?php
session_start();
$page = 'mypage';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>
<h1>Edit your password</h1>
<div class="container leftborder">As a user you can edit your own password. Just change the form and hit edit.</div>
<?php
if (!isset($_SESSION['signed_in']) or !isset($_GET['id'])) {
    print('<div class="container leftborder">You must <a href="login.php");">login</a> first</div>');
    header("Refresh:3; url=login.php");
} else {
    if ($_SESSION['signed_in'] == $_GET['id']) {
        include 'connect.php';
        include 'testinput.php';
        // Create connection
        $conn = new mysqli($server, $username, $password, $database);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            if (!empty($_POST)) {
                //Hämta lösenorden
                $oldpassword = test_input($_POST["old"]); $oldpassword = hash('sha256', $oldpassword); $newpassword = test_input($_POST["new"]); $newpassword = hash('sha256', $newpassword); $confirmpassword = test_input($_POST["confirm"]); $confirmpassword = hash('sha256', $confirmpassword);
                if (($newpassword == $confirmpassword) && ($newpassword !== $oldpassword)) {
                    //Kollar att det blev rätt
                    $sql = "SELECT * FROM users WHERE user_pass='$oldpassword' AND user_id= " . $_SESSION['user_id'];
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    if ($result->num_rows > 0) {
                        $user = $row['user_id'];
                        $sql = "UPDATE users SET user_pass='$newpassword' WHERE user_id= " . $user;
                        $result = $conn->query($sql);
                        if ($conn->affected_rows > 0) {
                            print('<div class="container leftborder">You updated your password, don\'t forget it!</div>');
                            header("Refresh:3; url=index.php");
                        }
                    } else {
                        print('<div class="container leftborder">Something went wrong, try again later.</div>');
                        header("Refresh:5; url=index.php");
                    }
                } else {
                    print('<div class="container leftborder">New password dose not match or is same as old</div>');
                    header("Refresh:5; url=index.php");
                }
            } else {
                $sql = "SELECT * FROM users WHERE user_id = " . $_SESSION['user_id'];
                $result = $conn->query($sql);
                //Bara 1 user som ska byta lösen
                if ($result->num_rows == 1) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        if ($row['user_id'] == $_SESSION['user_id']) {
                            print('<form method="post" action="">');
                            print('<span class="formName">Current: </span><input type="text" name="old"><br>');
                            print('<span class="formName">New: </span><input type="text" name="new"><br>');
                            print('<span class="formName">Confirm: </span><input type="text" name="confirm"><br>');
                            print('<span class="formName">&nbsp;</span><input type="submit" name="post" value="Change"><br></form>');
                            //Kolla om det finns post data och updatera topicen om det finns
                        } else {
                            print('<div class="container leftborder">You in the wrong place</div>');
                            header("Refresh:3; url=index.php");
                        }
                    }
                } else {
                    print('<div class="container leftborder">You must <a href="login.php");">login</a> first</div>');
                    header("Refresh:3; url=login.php");
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