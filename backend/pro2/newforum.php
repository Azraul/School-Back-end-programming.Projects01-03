<?php
session_start();
$page='forum';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php'; ?>

<?php
if (isset($_SESSION['signed_in']) && $_SESSION['user_id']>1) {
print ('<h1>Make a new sub forum</h1>');
print ('<p>As an admin you can make a new forum. Just fill in the category and description for the forum.</p>');
print ('<form method="post" action="newforumADD.php">');
    
print ('<span class="formName">Category: </span><input type="text" name="category" value="" placeholder="Meme Forum"><br>');

print ('<span class="formName">Description: </span><textarea name="description" rows="5" cols="40" placeholder="This forum is for posting ( ͡° ͜ʖ ͡°) and memes."></textarea><br>');

print ('<span class="formName">&nbsp;</span><input type="submit" name="registrera" value="Create"><br></form>');
} else {
    print('<div class="container leftborder">You must <a href="login.php");">login</a> first!</div>');
}
?>
<?php
include 'footer.php';
?>