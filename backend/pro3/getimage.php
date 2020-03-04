<?php
if (isset($_GET['image']) && !empty($_GET['image'])) {
    //Testa input so sql is secure
    include 'testinput.php';
    $image = test_input($_GET['image']);
    //include the connect
    include 'connect.php';
    $conn = new mysqli($server, $username, $password, $database);
    $sql = "SELECT * FROM images WHERE image_id = ". $image .";";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<img onmouseover='imageajax(this.src)' src='gallery/".$row['image_filename']."' class='foto'><br><span onclick='hide(this.id)' class='popuptext hidden' id='imageinfo".$row['image_filename']."'></span><br>";
        }
    }
    $conn->close();
}
?>