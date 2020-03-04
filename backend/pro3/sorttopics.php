<?php
if (isset($_GET['order']) && !empty($_GET['order'])) {
    //Testa input so sql is secure
    include 'testinput.php';
    $order = test_input($_GET['order']);
    include 'connect.php';
    $conn = new mysqli($server, $username, $password, $database);
    switch ($order) {
        case "Latest":
            $sql = "SELECT *, users.user_id, users.user_name FROM topics INNER JOIN users ON topics.topic_by=users.user_id ORDER BY topic_date DESC LIMIT 5;";
            break;
        case "Upvotes":
            $sql = "SELECT *, users.user_id, users.user_name FROM topics INNER JOIN users ON topics.topic_by=users.user_id ORDER BY length(topic_upvote) DESC LIMIT 5;";
            break;
        case "Downvotes":
            $sql = "SELECT *, users.user_id, users.user_name FROM topics INNER JOIN users ON topics.topic_by=users.user_id ORDER BY length(topic_downvote) DESC LIMIT 5;";
            break;
        default:
            exit();
    }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $datetime = new DateTime($row['topic_date']);
            print('<div class="container leftborder"><a href="category.php?id=' . $row['topic_cat'] . '&topic=' . $row['topic_id'] . '"><h4>' . $row['topic_subject'] . '</a></h4><div class="start"> ' . $row['topic_content'] . '</div><div class="end">By: <a href="user.php?id=' . $row['user_id'] . '">' . $row['user_name'] . '</a><br> time: ' . $datetime->format('H:i - d.m.Y') . '</div></div>');
        }
    } else {
        print '<div class="container leftborder">topic unavailable</div>';
    }
    $conn->close();
}
