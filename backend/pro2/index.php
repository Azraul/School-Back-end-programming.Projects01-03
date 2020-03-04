<?php
session_start();
$page = 'index';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>

<h1>Welcome to Backend project 2</h1>
<div class="container leftborder">
    <div class="clear"></div>
    <div class="start">
        <p>This is my 2nd project in backend, the goal of this project is to be an introduction to databases with mySQL and PHP. This project is very open and as such I have decided to make something different.</p>
        <p>A top reason the internet is amazing lies in its ability to connect people. One of the best ways in my opinion to communicate with people on the internet is through forums, be it a big open forum like reddit or a more private one like a guild forum for a gamer group.</p>
        <p>Which is why I decided to explore and try to learn the basics behind making a forum. The image next to this text, if you click it, shows the original goals set out for this project.</p>
        <p>The idea is to atleast have some users, that can make forum threads and reply to said threads and then to have some moderator/admin that can make different kinds of forums for the users to post/spam in.</p>
        <p>Of course like any good <a href="category.php">forum</a>, anyone can read it, so go ahead and read and if you happen to find something you like, why not <a href="signup.php">register</a> and join in on the fun?<p>
</div>
    <div class="end"><a href="siteplan.svg">
    <img class="images" src="siteplan.svg" alt="Siteplan"/></a>
    </div>

</div>
<?php
include 'footer.php';
?>