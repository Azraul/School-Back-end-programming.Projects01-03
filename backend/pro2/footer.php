<div class="footer">
<div class="start">
<?php
if (isset($_SESSION['signed_in'])) {
    print('Currently logged in as ');
    switch ($_SESSION['user_level']) {
        case 0:
            print('user ' . $_SESSION['user_name']);
            break;
        case 1:
            print('Moderator ' . $_SESSION['user_name']);
            break;
        case 2:
            print('Admin ' . $_SESSION['user_name']);
            break;
        default:
            break;
    }
} else {
    print ('Currently browsing as guest, <a href="login.php");">login</a> or <a href="signup.php");">Register</a>');
}

?>
</div>
<div class="end">Created by Kristoffer 2019</div></div>
</div><!-- content -->
</div><!-- wrapper -->
</body>
</html>