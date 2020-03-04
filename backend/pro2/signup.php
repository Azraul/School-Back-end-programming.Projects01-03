<?php
session_start();
$page='signup';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php'; ?>

<?php
if (!isset($_SESSION['signed_in'])) {
print ('<h1>Sign up today!</h1>
<div class="container leftborder">Please fill in the form below to be added to our site</div>
<form method="post" action="signupADD.php">
    
<span class="formName">Name: </span><input type="text" name="namn" value=""><br>

<span class="formName">Lösenord:</span> <input type="text" name="losen" value=""><br>

<span class="formName">epost:</span> <input type="text" name="epost" value=""><br>

<span class="formName">&nbsp;</span><input type="submit" name="registrera" value="Register">
</form>');
} else {
    print '<div class="container leftborder">You are already logged in, <a href="logout.php" onclick="return confirm(\'Are you sure you want to logout?\');">logout</a>?.</div>';
}
?>
<?php
include 'footer.php';
?>