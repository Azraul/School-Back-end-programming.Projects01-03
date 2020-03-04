<?php
session_start();
$page = 'admin';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>
<?php
//Kollar att du är admin
if ((isset($_SESSION['signed_in'])) && ($_SESSION['user_id'] > 1)) {
    print('<h1>Change user email</h1><div class="admintip">Change the users email</div>');
    if (!isset($_GET['id'])) {
        print('<div class="admintip">You must choose a user first</div>');
    } else {
        include 'connect.php';
        // Create connection
        $conn = new mysqli($server, $username, $password, $database);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            if (!empty($_POST)) {
                print('<div class="admintip">Change in progress</div>');
                include 'testinput.php';
                $email = test_input($_POST["new_email"]);
                if (!empty($email)) {
                    $sql = "UPDATE users SET user_email='$email' WHERE user_id = " . $_POST['user_id'];
                    $result = $conn->query($sql);
                    if ($conn->affected_rows > 0) {
                        print('<div class="admintip">New email: ' . $email . ' for ' . $_POST['user_name'] . '</div>');
                    }
                } else {
                    print('<div class="admintip">Something went wrong.</div>');
                }
            } else {
                $sql = "SELECT * FROM users WHERE user_id = " . $_GET['id'];
                $result = $conn->query($sql);
                if ($result->num_rows == 1) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        print('<form method="post" action="">');
                        print('<span class="formName">Forum: </span><input name="user_name" type="text" readonly="readonly" value="' . $row['user_name'] . '"></input><br>');
                        print('<span class="formName">Forum: </span><input name="user_id" type="text" readonly="readonly" value="' . $row['user_id'] . '"></input><br>');
                        print('<span class="formName">old email: </span><input name="old_email" type="text" readonly="readonly" value="' . $row['user_email'] . '"></input><br>');
                        print('<span class="formName">New email: </span><input name="new_email" type="text" value=""></input><br>');
                        print('<span class="formName">&nbsp;</span><input type="submit" name="post" value="Update" onclick="return confirm(\'Are you sure you want to change this user\'s email?\');"><br></form>');
                        //Kolla om det finns post data och updatera topicen om det finns
                    }
                } else {
                    print('Nothing to return. Try again later.');
                }
            }
        }
        $conn->close();
    }
} else {
    print('<div class="container leftborder">You must <a href="login.php");">login</a> and prove that you are an admin!</div>');
    header("Refresh:3; url=login.php");
}
?>

<?php
include 'footer.php';
?>