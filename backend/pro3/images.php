<?php
session_start();
$page = 'images';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>

<h1>Image gallery</h1>
<div class="container leftborder">
    <?php
/**** From projekt 1; Dynamiskt bildgalleri med guiden:
 **** https://thevdm.com/2014/10/25/a-very-simple-php-photo-gallery/
 ****/
$galleryDir = 'gallery/';
foreach (glob("$galleryDir{*.jpg,*.gif,*.png,*.jpeg}", GLOB_BRACE) as $photo) {
    $imgName = explode("/", $photo);
    $imgName = end($imgName);
    print('<a href="'.$photo.'" title="'.$imgName.'"><div class="imagesfotobox"><img onmouseover="imageajax(this.src)" src="'.$photo.'" class="foto topicimage"><br><span class="fotoNamn"/>'.$imgName.'</span><br></a><span onclick="hide(this.id)" class="popuptext hidden" id="imageinfo'.$imgName.'"></span><br></div>');
}
?>
</div>
<?php
if (isset($_SESSION['signed_in'])) {
    echo ('<div class="container leftborder">
    <form method="POST" action="images.php" enctype="multipart/form-data">
    <span class="formName">New image: </span>
    <input type="file" name="fileToUpload" id="fileToUpload"><br>
    <span class="formName">Max 2mb</span>
    <input type="submit" value="Upload" name="submit">
    </form></div>');
}
if (!empty($_POST) && isset($_SESSION['signed_in'])) {
    //Also checks if there is a file with a name, couse that's pretty important
    if (basename($_FILES["fileToUpload"]["name"]) != "") {
        include 'testinput.php';
        $image_by = $_SESSION['user_id'];
        $image_filename = test_input(basename($_FILES["fileToUpload"]["name"]));
        $image_time = new Datetime();
        $image_time = $image_time->format('Y-m-d H:i:s');
//w3 schools upload.php && pro1

        $galleryDir = 'gallery/';
        $target_file = $galleryDir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                echo '<div class="container leftborder">File is image - ' . $check["mime"] . '</div>';
                $uploadOk = 1;
            } else {
                echo '<div class="container leftborder">This is not an image</div>';
                $uploadOk = 0;
                exit();
            }

// Check if file already exists
            if (file_exists($target_file)) {
                echo '<div class="container leftborder">This image already exists</div>';
                $uploadOk = 0;
                exit();
            }
// Check file size
            if ($_FILES["fileToUpload"]["size"] > 2000000) {
                echo '<div class="container leftborder">Make the image smaller</div>';
                $uploadOk = 0;
                exit();
            }
// Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                echo '<div class="container leftborder">Only JPG, JPEG, PNG & GIF allowed</div>';
                $uploadOk = 0;
                exit();
            }
// Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo '<div class="container leftborder">Something went wrong with your upload</div>';
// if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    addimagetodatabase($image_by, $image_filename, $image_time);
                    echo '<div class="container leftborder">' . basename($_FILES["fileToUpload"]["name"]) . ' has been uploaded</div>';
                } else {
                    echo '<div class="container leftborder">Something isn\'t quite right, try again</div>';
                    exit();
                }
            }
        }
    } else {
        echo '<div class="container leftborder">No file selected</div>';
    }
}

function addimagetodatabase($image_by, $image_filename, $image_time)
{
    include 'connect.php';
    $conn = new mysqli($server, $username, $password, $database);
    $conn->set_charset('utf-8');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo '<div class="container leftborder">Uploading image, please standby</div>';
    //No need to check if image exists since we're checking the folder already and we're not displaying them by filename, rather with their uniqe ids
    $sql = "INSERT INTO images (image_by, image_filename,image_time)
            VALUES ('$image_by', '$image_filename', '$image_time');";
    if ($conn->query($sql) === true) {
        $sql = "SELECT * FROM images ORDER BY image_id DESC LIMIT 1";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo '<div class="container leftborder">';
            echo '<a href="gallery/' . $row['image_filename'] . '" title="' . $row['image_filename'] . '"><div class="fotoBox"><img onmouseover="imageajax(this.src)" src="gallery/' . $row['image_filename'] . '" class="foto"><br><span class="fotoNamn">' . $row['image_filename'] . '</span></div></a></div>';
        }
    } else {
        echo '<div class="container leftborder">Error: ' . $sql . "<br>" . $conn->error . '</div>';
    }
    $conn->close();
}
?>
<div id="imageinfo"></div>
<?php
include 'footer.php';
?>