<?php
session_start();
$page = 'login';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>
<h1>Login</h1>
<?php


//Om man redan är inloggad
if (isset($_SESSION['signed_in'])){
        print '<div class="container leftborder">You are already logged in, <a href="logout.php" onclick="return confirm(\'Are you sure you want to logout?\');">logout</a>?.</div>';
} elseif (isset($_POST["loginTry"])){
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
$password = test_input($_POST["losen"]);
$password = hash('sha256', $password);
$timesvisited;
$lastvisit;

$sql = "SELECT * FROM users WHERE (user_pass='$password' AND user_email='$name') OR (user_pass='$password' AND user_name='$name')";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    print '<div class="container leftborder">Logged in, taking you to the front page in a moment</div>';
//set the $_SESSION['signed_in'] variable to TRUE
    $_SESSION['signed_in'] = true;
//we also put the user_id and user_name values in the $_SESSION, so we can use it at various pages
    while($row = $result->fetch_assoc()) {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_name'] = $row['user_name'];
        $_SESSION['user_level'] = $row['user_level'];
        $timesvisited = $row['user_visits'];
        $lastvisit = $row['user_newvisit'];
    }
    $date = new Datetime();
    $date = $date->format('Y-m-d H:i:s');
    $timesvisited++;
    $sql = "UPDATE users SET user_visits='$timesvisited', user_newvisit='$date', user_lastvisit='$lastvisit' WHERE user_id = " . $_SESSION['user_id'];
    $result = $conn->query($sql);
    header("Refresh:2; url=index.php");
} else {
    print '<div class="container leftborder">user or password is wrong, taking you back to the login page</div>';
    header("Refresh:3; url=login.php");
}

$conn->close();
} else{
    print('<div class="container leftborder">You must <a href="login.php");">login</a> first!</div>');
}
?>

<?php
include 'footer.php';
?>