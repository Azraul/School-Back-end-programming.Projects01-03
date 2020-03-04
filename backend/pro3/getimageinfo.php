<?php
if (isset($_GET['image']) && !empty($_GET['image'])) {
    //Testa input so sql is secure
    include 'testinput.php';
    $image = test_input($_GET['image']);
    include 'connect.php';
    $conn = new mysqli($server, $username, $password, $database);
    $sql = "SELECT *, users.user_name FROM images INNER JOIN users ON images.image_by=users.user_id WHERE image_filename = '". $image ."';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $date = new Datetime($row['image_time']);
            $date = $date->format('Y-m-d');
            echo ('Image by '. $row['user_name'] .'<br>Uploaded at '. $date);
        }
    }
    $conn->close();
}
?>