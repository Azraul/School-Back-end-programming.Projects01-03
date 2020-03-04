<?php
include 'connect.php';
include 'testinput.php';
$conn = new mysqli($server, $username, $password, $database);
$conn->set_charset('utf-8');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    print('No connection');
} else {
    $search = $_GET['q'];
    $search = test_input($search);
    if (strlen($search) > 0) {
        $sql = "SELECT * FROM topics WHERE topic_subject LIKE '%$search%' ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='container leftborder'><a href='category.php?topic=".$row['topic_id']."'>".$row['topic_subject']."</a></div>";
            }
        }
    }
}
$conn->close();