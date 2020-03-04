<?php
//all bow before admin
if ((isset($_SESSION['signed_in'])) && ($_SESSION['user_level']>1)){
    echo '<a ';
    echo ($page == 'admin') ? "class='activeNav'" : "";
    echo 'href="admin.php">admin</a>';
}
?>
<a <?php echo ($page == 'index') ? "class='activeNav'" : ""; ?> href="index.php">Home</a>
<a <?php echo ($page == 'forum') ? "class='activeNav'" : ""; ?> href="category.php">Forums</a>
<a <?php echo ($page == 'search') ? "class='activeNav'" : ""; ?> href="search.php">Search</a>
<a <?php echo ($page == 'images') ? "class='activeNav'" : ""; ?> href="images.php">Images</a>
<!--- if login --->
<?php
if (isset($_SESSION['signed_in'])){
    echo '<a ';
    echo ($page == 'mypage') ? "class='activeNav'" : "";
    echo 'href="user.php?id='.$_SESSION['user_id'].'">My page</a>';
    echo '<a ';
    echo ($page == 'login') ? "class='activeNav'" : "";
    echo 'href="logout.php" onclick="return confirm(\'Are you sure you want to logout?\');">Logout</a>';
}else {
    echo '<a ';
    echo ($page == 'login') ? "class='activeNav'" : "";
    echo 'href="login.php">Login</a>';
    //login or register
    echo '<a ';
    echo ($page == 'signup') ? "class='activeNav'" : "";
    echo 'href="signup.php">Register</a>';
}
?>
<a <?php echo ($page == 'about') ? "class='activeNav'" : ""; ?> href="about.php">About</a>
<a <?php echo ($page == 'report') ? "class='activeNav'" : ""; ?> href="report.php">Report</a>
<!--- Globalnavigation for backend -->
<?php
$project='3';
include 'backendGlobalNavigation.php';
?>