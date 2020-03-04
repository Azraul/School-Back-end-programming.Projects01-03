<?php
session_start();
$page = 'signup';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>

<h1>Creating new user</h1>

<div class="container leftborder">If no error below you can login after this process takes you to the front page</div>

<?php
if (isset($_SESSION['signed_in'])) {
    print '<div class="container leftborder">You are already logged in, <a href="logout.php" onclick="return confirm(\'Are you sure you want to logout?\');">logout</a>?.</div>';
} else {
//Inloggnings upggifterna
    include 'connect.php';
    include 'testinput.php';

// Create connection
    $conn = new mysqli($server, $username, $password, $database);

// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $name = test_input($_POST["namn"]);
    $email = test_input($_POST["epost"]);
    $password = test_input($_POST["losen"]);
    $password = hash('sha256', $password);

//Tror inte det är med daylight savings??
    $date = new Datetime();
    $date = $date->format('Y-m-d H:i:s');

//Kolla om användarnamnet redan finns
    $sql = "SELECT * FROM users WHERE user_name='$name' or user_email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        print('<div class="container leftborder">A user with this name already exists, taking you back.</div>');
        header('Refresh: 3; url=signup.php');
    } else {
        //Skapa användaren
        //Du besöker ju oss när du registrerar så därför kommer newvisist med också
        $sql = "INSERT INTO users (user_name, user_pass, user_email, user_date,user_newvisit, user_level)
VALUES ('$name','$password', '$email','$date','$date', '0');";

        if ($conn->query($sql) === true) {
            echo '<div class="container leftborder">New user created! Taking you to the front page in 3.</div>';
            header('Refresh: 3; url=index.php');
        } else {
            echo '<div class="container leftborder">Error: " . $sql . "<br>" . $conn->error . "</div>';
            echo '<div class="container leftborder">Sorry, something went wrong, please try again</div>';
        }
    }
    $conn->close();
}
?>
<?php
include 'footer.php';
?>