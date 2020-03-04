<?php
session_start();
$page = 'login';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>
<h1>Logout</h1>

<?php
//Att man faktiskt är inloggad
if (isset($_SESSION['signed_in'])){

//Direkt från PHP manualen - https://secure.php.net/session_destroy
//Must run a session already
// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();
header("Refresh:5; url=index.php");
print ('<div class="container leftborder">You logged out');
print ("<br>Thanks for using our page, we will redirect you to the front page in a moment</div>");
header("Refresh:3; url=index.php");
}
else {
    print('<div class="container leftborder">You must <a href="login.php");">login</a> first!</div>');
}

include 'footer.php';
?>