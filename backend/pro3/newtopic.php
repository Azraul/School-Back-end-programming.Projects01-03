<?php
session_start();
$page = 'forum';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>
<?php
if (isset($_SESSION['signed_in'])) {
    include 'connect.php';
    $conn = new mysqli($server, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //Print form
    print ('<h1>Make a new sub forum</h1><div id ="topic_form"class="container leftborder">As an user you can make a new topics. Just use the form below. Remeber to pick the correct forum for you topic</div>');
    print ('<form method="post" name="topic" action="newtopicADD.php">');
    print('<span class="formName">Topic Title: </span><input type="text" name="title" value="" placeholder="Title"><br>');
    print ("<span class='formName'>&nbsp;</span><input type='button' name='pollbtn' onClick='makepoll()' value='Add poll'><br>");
    $sql = "SELECT * FROM images;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        print('<span class="formName">Image: </span><select name="image" onChange="updateimg(this.value)">');
        print('<option value="0" >No image</option>');
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            print('<option value="' . $row['image_id'].'" >' . $row['image_filename'] . '</option>');
        }
        print('</select><br>');
    }
    print('<div id="imgpreview" class="fotobox"></div>');
    print ("<input type='hidden' name='pollamount' value='1'>");
    print('<span class="formName">Content: </span><textarea name="content" rows="5" cols="40" placeholder="Your content here"></textarea><br>');
    print ('<div id="pollInputs"></div>');
    print ("<div id='rowhandler'><span class='formName'>&nbsp;</span><input type='button' onClick='addpollrow()' value='Add row'><input type='button' onClick='removepollrow()' value='Remove row'></div><br>");
    $sql = "SELECT * FROM categories;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        print('<span class="formName">Forum: </span><select name="category">');
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            print('<option value="' . $row['cat_id']);
            if (isset($_GET['cat'])) {
                if ($_GET['cat'] == $row['cat_id']) {
                    print(' " selected ');
                }
            }
            print('" >' . $row['cat_name'] . '</option>');
        }
        print('</select><br>');
        print('<span class="formName">&nbsp;</span><input type="submit" name="post" value="Post"><br></form>');
    } else {
        print('<span class="formName">&nbsp;</span><input type="submit" name="post" value="Post"><br></form>');
        print('<div class="container leftborder">No forums to get, try making a topic later</div>');
    }
    $conn->close();
} else {
    print('<div class="container leftborder">You must <a href="login.php");">login</a> first!</div>');
}
?>
<?php
include 'footer.php';
?>