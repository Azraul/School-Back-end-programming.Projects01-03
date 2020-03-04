<?php
session_start();
$page = 'about';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>
<h1>About</h1>
<div class="container leftborder">This site was made as part of a school project for the course backend at Arcada University of Applied Sciences 2019.<br>
You can read the final <a href="report.php">report here</a>.
</div>

<?php
//Inloggnings upggifterna
include 'connect.php';
// Create connection
//Min räkna variable, initierad
//$index;
$conn = new mysqli($server, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo '<div class="container leftborder">Currently this site has ';
$sql = "SELECT cat_id FROM categories";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    print($result->num_rows . ' active forums with, ');
} else {
    print(" (could not fetch forum categories data) ");
}
$sql = "SELECT topic_id FROM topics";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    print($result->num_rows . ' active topics and ');
    //Provade MAX() men den gillade inte när jag skickade date some parameter
    $sql = "SELECT topic_date FROM topics ORDER BY topic_date ASC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            //Jag vill inte gör projekt 1 uppgiften igen
            //men det blev så iallafall så det blir snyggt
            $datenow = new DateTime();
            $datenow->format('d.m.Y H:i:s');
            $datelatest = new DateTime($row['topic_date']);
            print('with our newest topic being made ');
            $interval = $datelatest->diff($datenow);
            if ($interval->y != 0) {
                echo ($interval->y . " years and ");
            }
        
            if ($interval->m == 1 or $interval->m == -1) {
                echo ($interval->m . " month and ");
            } elseif ($interval->m != 0) {
                echo ($interval->m . " months and ");
            }
        
            if ($interval->d == 1 or $interval->d == -1) {
                echo ($interval->d . " day and ");
            } elseif ($interval->d != 0) {
                echo ($interval->d . " days and ");
            }
        
            if ($interval->h == 1 or $interval->h == -1) {
                echo ($interval->h . " hour and ");
            } elseif ($interval->h != 0) {
                echo ($interval->h . " hours and ");
            }
        
            if ($interval->i == 1 or $interval->i == -1) {
                echo ($interval->i . " minute and ");
            } elseif ($interval->i != 0) {
                echo ($interval->i . " minutes and ");
            }        
            echo $interval->s;        
            echo " seconds ago.<br> ";
        }
    }
} else {
    print(" (could not fetch topic data) ");
}
$sql = "SELECT post_id FROM posts";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    print('We also have '.$result->num_rows . ' posts written by our ');
} else {
    print(" (could not fetch post data) ");
}
$sql = "SELECT user_id FROM users";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    print($result->num_rows . ' active users ');
    //Provade MIN() men den gillade inte när jag skickade date some parameter
    $sql = "SELECT user_date FROM users ORDER BY user_date ASC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            //Samma som ovan men det blev iallafall snyggt för "bossen"
            $dateuser = new DateTime($row['user_date']);
            $datenow = new DateTime();
            $datenow->format('d.m.Y H:i:s');
            print('with our oldest user being made ');
            $interval = $dateuser->diff($datenow);
            if ($interval->y != 0) {
                echo ($interval->y . " years and ");
            }
        
            if ($interval->m == 1 or $interval->m == -1) {
                echo ($interval->m . " month and ");
            } elseif ($interval->m != 0) {
                echo ($interval->m . " months and ");
            }
        
            if ($interval->d == 1 or $interval->d == -1) {
                echo ($interval->d . " day and ");
            } elseif ($interval->d != 0) {
                echo ($interval->d . " days and ");
            }
        
            if ($interval->h == 1 or $interval->h == -1) {
                echo ($interval->h . " hour and ");
            } elseif ($interval->h != 0) {
                echo ($interval->h . " hours and ");
            }
        
            if ($interval->i == 1 or $interval->i == -1) {
                echo ($interval->i . " minute and ");
            } elseif ($interval->i != 0) {
                echo ($interval->i . " minutes and ");
            }        
            echo $interval->s;        
            echo " seconds ago.<br> ";
        }
    }
} else {
    print(" (could not fetch user data) ");
}
print ('</div>');

$conn->close();
//Stäng alltid annars får du minus poäng
?>

<?php
include 'footer.php';
?>