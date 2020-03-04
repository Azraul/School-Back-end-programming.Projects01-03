<?php
session_start();
$page = 'forum';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>

<?php
if (isset($_SESSION['signed_in'])) {
    if ($_SESSION['user_level'] >= 0) {
//Inloggnings upggifterna
        include 'connect.php';
        include 'testinput.php';

// Create connection
        $conn = new mysqli($server, $username, $password, $database);

// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        echo '<div class="container leftborder">Creating topic, please standby</div>';

//Hämta datan
        $topic_category = $_POST["category"];
        $topic_name = test_input($_POST["title"]);
        $topic_content = test_input($_POST["content"]);
        $topic_content = str_replace("'", '&#8217;', $topic_content);
        $topic_creator = $_SESSION['user_id'];
//Blir ju inte med daylight savings
        $date = new Datetime();
        $date = $date->format('Y-m-d H:i:s');

//Kolla om topicen redan finns
        $sql = "SELECT * FROM topics WHERE topic_subject='$topic_name' AND topic_cat='$topic_category'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            print('<div class="container leftborder">Topic already exists in this fourm, please rename your topic and try again</div>');
        } else {
            //Skapa topic
            $sql = "INSERT INTO topics (topic_subject, topic_date,topic_content, topic_cat, topic_by)
VALUES ('$topic_name', '$date', '$topic_content', '$topic_category', '$topic_creator');";

            if ($conn->query($sql) === true) {
                $sql = "SELECT topic_id FROM topics ORDER BY topic_id DESC LIMIT 1";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                echo '<div class="container leftborder">New topic created! Taking you there in 3 seconds</div>';
                header('Refresh: 3; url=category.php?topic=' . $row['topic_id']);
            } else {
                echo '<div class="container leftborder">Error: ' . $sql . "<br>" . $conn->error . '</div>';
                echo '<div class="container leftborder">Taking you back in 5 seconds</div>';
                header('Refresh: 5; url=newtopic.php');
            }
        }
        $conn->close();
    }
} else {
    print('<div class="container leftborder">You must <a href="login.php");">login</a> first!</div>');
}
?>
<?php
include 'footer.php';
?>