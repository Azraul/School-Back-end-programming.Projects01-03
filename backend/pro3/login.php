<?php
session_start();
$page = 'login';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>
<?php
if (!isset($_SESSION['signed_in'])){
print ('<h1>Login</h1>
<div class="container leftborder">Login below</div>

<form method="post" action="loginCheck.php">

    <span class="formName">Name: </span><input type="text" name="namn" value=""><br>

    <span class="formName">Lösenord:</span> <input type="text" name="losen" value=""><br>

    <span class="formName">&nbsp;</span><input type="submit" name="loginTry" value="Logga in">
    </form>');
} else {
    print '<div class="container leftborder">You are already logged in, <a href="logout.php" onclick="return confirm(\'Are you sure you want to logout?\');">logout</a>?.</div>';
}
?>
<?php
include 'footer.php';
?>