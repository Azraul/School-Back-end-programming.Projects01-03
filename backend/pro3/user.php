<?php
session_start();
$page = 'mypage';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>
<?php
//All ska kunna se users men om man är inloggad och ser sig själv kommer alternativet att byta lösenord
//Inloggnings upggifterna
if (!isset($_GET['id'])) {
    echo ('<div class="container leftborder">Please browser a user</div>');
} else {
    include 'connect.php';
    $conn = new mysqli($server, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM users WHERE user_id = " . $_GET['id'];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $datejoined = new DateTime($row['user_date']);
            $datenow = new DateTime();
            $datenow->format('Y-m-d H:i:s');
            $interval = $datejoined->diff($datenow);
            if (isset($_SESSION['signed_in']) && $row['user_id'] == $_SESSION['user_id']) {
                print('<h1>Your page</h1>');
                print('<div class="container leftborder">Welcome <b>');
                switch ($row['user_level']) {
                    case 0:
                        print('user ');
                        break;
                    case 1:
                        print('moderator ');
                        break;
                    case 2:
                        print('Admin ');
                        break;
                    default:
                        break;
                }
                print($row['user_name'] . '</b>, we hope you are having a nice day!');
                print('<br>Do you wish to change <a href="editpassword.php?id=' . $_SESSION['user_id'] . '");">password</a>?');
                print('<p>You have been a user since ' . $datejoined->format('d-m-Y') . " that's ");
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
                echo " seconds!";
                print('<br>Your last visit was ');
                $datevisit = new DateTime($row['user_lastvisit']);
                $interval = $datevisit->diff($datenow);
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
                echo " seconds ago ";
                print(' and you have visited us ' . $row['user_visits'] . ' times.</p></div>');
            } else {
                print('<h1>' . $row['user_name'] . "'s page</h1>");
                print('<div class="container leftborder"><p><b>' . $row['user_name'] . '</b> has been a member since ' . $datejoined->format('d-m-Y') . '</p></div>');
            }

        }

    } else {
        print('<div class="container leftborder">Nothing to see on this user it would seem!</div>');
    }
    //Order by, eftersom det fanns i speccs
    $sql = "SELECT topics.topic_by, topics.topic_cat, topics.topic_date,topics.topic_id,topics.topic_subject, topics.topic_content, users.user_id, users.user_name FROM (topics INNER JOIN users ON topics.topic_by=users.user_id) WHERE topics.topic_by = " . $_GET['id'] . " ORDER BY topic_date DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        if (isset($_SESSION['signed_in']) && $_GET['id'] == $_SESSION['user_id']) {
            print('<div class="container leftborder">You have made the following topics:</div>');
        } else {
            echo ('<div class="container leftborder">The following posts have been made by this user:</div>');
        }
        while ($row = $result->fetch_assoc()) {
            $datetime = new DateTime($row['topic_date']);
            print('<div class="container leftborder"><div class="start"><a href="category.php?id=' . $row['topic_cat'] . '&topic=' . $row['topic_id'] . '">' . $row['topic_subject'] . "</a><br>" . $row['topic_content'] . '</div><div class="end">By: <a href="user.php?id=' . $row['user_id'] . '">' . $row['user_name'] . '</a><br> time: ' . $datetime->format('H:i - d.m.Y') . "</div></div>");
        }
    } else {
        if (isset($_SESSION['signed_in']) && $_GET['id'] == $_SESSION['user_id']) {
            print('<div class="container leftborder">You have med no topics, pick a <a href="category.php">forum</a> and make some.</div>');
        } else {
            print('<div class="container leftborder">This user has no topics</div>');
        }
    }

    $conn->close();
//Stäng alltid annars får du minus poäng
}

?>

<?php
include 'footer.php';
?>