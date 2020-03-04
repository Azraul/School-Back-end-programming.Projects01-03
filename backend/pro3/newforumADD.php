<?php
session_start();
$page = 'forum';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>

<h1>Creating new forum</h1>

<div class="container leftborder">Read below for progress</div>

<?php
if (isset($_SESSION['signed_in'])) {
    if ($_SESSION['user_level'] > 0) {
//Inloggnings upggifterna
        include 'connect.php';
        include 'testinput.php';

// Create connection
        $conn = new mysqli($server, $username, $password, $database);
        $conn->set_charset('utf-8');
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        print('<div class="admintip">Access granted...</div>');

//Hämta datan
        $forum_name = test_input($_POST["category"]);
        $forum_description = test_input($_POST["description"]);
        $forum_description = str_replace("'", '&#8217;', $forum_description);

//Kolla om användarnamnet redan finns
        $sql = "SELECT * FROM categories WHERE cat_name='$forum_name'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            print('<div class="admintip">A forum categry like that already exists</div>');
        } else {
            //Skapa användaren
            $sql = "INSERT INTO categories (cat_name, cat_description)
VALUES ('$forum_name','$forum_description');";

            if ($conn->query($sql) === true) {
                print('<div class="admintip">You made a new forum</div>');
                //header('Refresh: 5; url=addNewUser.php');
            } else {
                echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
                print('<div class="admintip">Taking you back in 5 seconds</div>');
                header('Refresh: 5; url=newforum.php');
            }
        }
        $conn->close();
    } else {
        echo '<div class="container leftborder">Only admins and moderators can create forums</div>';
    }
} else {
    print('<div class="container leftborder">You must <a href="login.php");">login</a> first!</div>');
}
?>
<?php
include 'footer.php';
?>