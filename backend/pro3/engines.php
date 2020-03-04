<?php
function create_conn()
{
    //CURRENTLY NOT THE LIVE DATABASE
    //connection to database function
$server = 'localhost';
$username   = 'kuvajaan';
$password   = 'GCWLLaCS6w';
$database   = 'kuvajaan';
    $conn = new mysqli($server, $username, $password, $database);
    $conn->set_charset('utf-8');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        print('<div class="container leftborder">Problem connecting to our database, please try searching later</div>');
    }
    return $conn;
}

//After being reminded to always check inputs
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/********* SEARCH ENGINES *************
 **** The print style is different ****
 ****** in search and categories ******
 *************************************/
//Show searched topics
function showtopics($search)
{
    $search = test_input($search);
    $conn = create_conn();
    //Search med all topics some har search texten
    $sql = "SELECT topics.topic_id, topics.topic_subject, topic_cat, topics.topic_date, users.user_name, topics.topic_content, users.user_id FROM topics INNER JOIN users ON topic_by=user_id WHERE topic_content LIKE '%$search%' OR topic_subject LIKE '%$search%' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $datetime = new DateTime($row['topic_date']);
            print('<div class="container leftborder"><div class="start"><a href="category.php?id=' . $row['topic_cat'] . '&topic=' . $row['topic_id'] . '">' . $row['topic_subject'] . "</a><br>" . $row['topic_content'] . '</div>');
            print('<div class="end">By: <a href="user.php?id=' . $row['user_id'] . '">' . $row['user_name'] . '</a><br> time: ' . $datetime->format('H:i - d.m.Y') . "</div></div>");
        }
    } else {
        print('<div class="container leftborder">No topics found!</div>');
    }
    $conn->close();
}

//Show searched posts
function showposts($search)
{
    $search = test_input($search);
    $conn = create_conn();
    $sql = "SELECT *, users.user_name FROM posts INNER JOIN users ON posts.post_by=users.user_id WHERE post_content LIKE '%$search%' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $datetime = new DateTime($row['post_date']);
            print('<div class="replycontainer"><div class="start">' . $row['post_content'] . "<br>" . '</div><div class="end">By: <a href="user.php?id=' . $row['user_id'] . '">' . $row['user_name'] . '</a><br> time: ' . $datetime->format('H:i - d.m.Y') . "</div>");
            print('</div>');
        }
    } else {
        print('<div class="replycontainer">No posts found!</div>');
    }

    $conn->close();
}

//Searchs for exactly that user and shows all their posts and topics
//TODO: AJAX SUGGESTION USERS
function showUserContent($search)
{
    $search = test_input($search);
    $conn = create_conn();
    $sql = "SELECT topics.topic_by, topics.topic_cat, topics.topic_date,topics.topic_id,topics.topic_subject, topics.topic_content, users.user_id, users.user_name FROM (topics INNER JOIN users ON topics.topic_by=users.user_id) WHERE users.user_name = '$search' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $datetime = new DateTime($row['topic_date']);
            print('<div class="container leftborder"><div class="start"><a href="category.php?id=' . $row['topic_cat'] . '&topic=' . $row['topic_id'] . '">' . $row['topic_subject'] . "</a><br>" . $row['topic_content'] . '</div><div class="end">By: <a href="user.php?id=' . $row['user_id'] . '">' . $row['user_name'] . '</a><br> time: ' . $datetime->format('H:i - d.m.Y') . "</div></div>");
        }
    } else {
        print('<div class="container leftborder">No topics by user <b>' . $search . '</b> found!</div>');
    }
    //Posts delen
    $sql = "SELECT *, users.user_name FROM posts INNER JOIN users ON posts.post_by=users.user_id WHERE users.user_name = '$search' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $datetime = new DateTime($row['post_date']);
            print('<div class="replycontainer"><div class="start">' . $row['post_content'] . "<br>" . '</div><div class="end">By: <a href="user.php?id=' . $row['user_id'] . '">' . $row['user_name'] . '</a><br> time: ' . $datetime->format('H:i - d.m.Y') . "</div>");
            print('</div>');
        }
    } else {
        print('<div class="replycontainer">No posts by user <b>' . $search . '</b> found!</div>');
    }
    $conn->close();
}

/**** CATEGORIES PART BELOW ****/

//Show all forums
function showALLforums()
{
    $conn = create_conn();
    $sql = "SELECT * FROM categories";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            print('<div class="container leftborder forumcategory"><a href="category.php?id=' . $row['cat_id'] . '"><h3>' . $row['cat_name'] . '</h3></a>' . $row['cat_description'] . '</div>');
        }
    } else {
        print('<div class="container leftborder">Nothing here, try again later</div>');
    }
    $conn->close();
}

//Gets the selected forum
function showforum($id)
{
    $id = test_input($id);
    $conn = create_conn();
    $sql = "SELECT * FROM categories WHERE cat_id = $id;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            print('<div class="container cat_leftborder forumcategory"><a href="category.php"><h3>Forums</a> - <a href="category.php?id=' . $row['cat_id'] . '">' . $row['cat_name'] . '</a></div>');
        }
    } else {
        print('<div class="container leftborder">Nothing here, try again later</div>');
    }
    $conn->close();
}

//Gets the selected topic
function showtopic($topic)
{
    $topic = test_input($topic);
    $conn = create_conn();
    $sql = "SELECT *, users.user_name FROM topics INNER JOIN users ON topics.topic_by=users.user_id WHERE topic_id = " . $topic . ";";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $datetime = new DateTime($row['topic_date']);
            print('<div class="container leftborder"><a href="category.php?id=' . $row['topic_cat'] . '&topic=' . $row['topic_id'] . '"><h4>' . $row['topic_subject'] . '</a>');
            if (isset($_SESSION['signed_in']) && !empty($_GET['topic'])) {
                //Quickfix
                print "<div class='end'>";
                votesystem($row['topic_id']);
                print "<div class='clear'></div></div>";
            }
            print('</h4><div class="start"> ' . $row['topic_content']);// . '</div>');
            if ($row['topic_image'] > 0 && !empty($_GET['topic'])) {
                getimageengine($row);
            }
            print ('</div>');
            print('<div class="end">By: <a href="user.php?id=' . $row['user_id'] . '">' . $row['user_name'] . '</a><br> time: ' . $datetime->format('H:i - d.m.Y') . "</div>");
            if (isset($_SESSION['signed_in']) && !empty($_GET['topic'])) {
                topicbuttons($row);
                showpoll($row);
            }
            print('</div>');
        }
    } else {
        print('<div class="container leftborder">Nothing here, try again later.</div>');
    }
    $conn->close();
}

//Gets alla posts for the topic
function showpostsBytopic($topic)
{
    $topic = test_input($topic);
    $conn = create_conn();
    $sql = "SELECT *, users.user_name FROM posts INNER JOIN users ON posts.post_by=users.user_id WHERE post_topic = " . $topic . ";";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $datetime = new DateTime($row['post_date']);
            print('<div class="replycontainer"><div class="start">' . $row['post_content'] . "<br>" . '</div><div class="end">By: <a href="user.php?id=' . $row['user_id'] . '">' . $row['user_name'] . '</a><br> time: ' . $datetime->format('H:i - d.m.Y') . "</div>");
            if (isset($_SESSION['signed_in']) && $row['user_id'] == $_SESSION['user_id']) {
                ownerbuttons($row);
            }
            print('</div>');
        }
    }
    $conn->close();
}

//Get the cat id from topic and then prints it with showforum()
function showforumBytopic($topic)
{
    $topic = test_input($topic);
    $conn = create_conn();
    $sql = "SELECT topic_cat FROM topics WHERE topic_id= " . $topic . ";";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            showforum($row['topic_cat']);
        }
    } else {
        print('<div class="container leftborder">Something is wrong with this forum or it might not exist, try again later.</div>');
    }
    $conn->close();
}

//Get the topic ids that matches the forum(cat)'s id and prints them with showtopic()
function showtopicsByforum($id)
{
    $id = test_input($id);
    $conn = create_conn();
    $sql = "SELECT topic_id FROM topics WHERE topic_cat = ".$id." ORDER BY topic_date DESC;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            showtopic($row['topic_id']);
        }
    } else {
        print('<div class="container leftborder">Nothing here, try again later or perhaps make a <a href="newtopic.php?cat=' . $_GET['id'] . '"> new topic</a>.</div>');
    }
    $conn->close();
}

//Topic buttons (reply and edit/delete or upvote/downvote)
function topicbuttons($row)
{
    print('<div class="clear"></div><div class="start">');
    print('<a class="topicbutton" href="newreply.php?topic=' . $row['topic_id'] . '">Reply</a>');
    if ($row['user_id'] == $_SESSION['user_id']) {
        ownerbuttons($row);
    }
    print('</div>');
}

//Works for post too now
function ownerbuttons($row)
{
    if (isset($row['topic_id'])) {
        print('<a class="topicbutton" href="edittopic.php?topic=' . $row['topic_id'] . '">Edit</a>');
        print('<a class="topicbutton" href="deletetopic.php?topic=' . $row['topic_id'] . '">Delete</a>');
    } elseif (isset($row['post_id'])) {
        print('<div class="clear"></div><div class="start">');
        print('<a class="topicbutton" href="editpost.php?post=' . $row['post_id'] . '">Edit</a>');
        print('<a class="topicbutton" href="deletepost.php?post=' . $row['post_id'] . '">Delete</a>');
        print('</div>');
    }
}

function votesystem($topic)
{
    $topic = test_input($topic);
    $id = $_SESSION['user_id'];
    $sumofvotes = 0;
    $upvotes = array();
    $downvotes = array();
    $conn = create_conn();
    $sql = "SELECT topic_upvote, topic_downvote FROM topics WHERE topic_id = " . $topic . ";";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            //json_decode, when you finally learnt what to google, 30 min => 30 seconds
            $upvotes = json_decode($row['topic_upvote']);
            $downvotes = json_decode($row['topic_downvote']);
        }
    }
    $conn->close();

    //error handling on getting the total number of votes
    //and if you have voted
    if (empty($upvotes) && empty($downvotes)) {
        $sumofvotes = 0;
        $upactive = false;
        $downactive = false;
    } elseif (empty($downvotes)) {
        $sumofvotes = count($upvotes);
        $upactive = checkvotes($upvotes, $id);
        $downactive = false;
    } elseif (empty($upvotes)) {
        $sumofvotes = 0 - count($downvotes);
        $upactive = false;
        $downactive = checkvotes($downvotes, $id);
    } else {
        $sumofvotes = count($upvotes) - count($downvotes);
        $upactive = checkvotes($upvotes, $id);
        $downactive = checkvotes($downvotes, $id);
    }
    //The vote buttons with some logic if you voted using ids since we send them later with onclick
    if ($upactive == true) {
        print('<span id="activeupvote" class="votebutton" onClick="vote(this.id,' . $topic . ',' . $_SESSION['user_id'] . ')">++</span>');
    } else {
        print('<span id="upvote" class="votebutton" onClick="vote(this.id,' . $topic . ',' . $_SESSION['user_id'] . ')">++</span>');
    }
    print('<span id="votes" class="votebutton">' . $sumofvotes . '</span>');
    if ($downactive == true) {
        print('<span id="activedownvote" class="votebutton" onClick="vote(this.id,' . $topic . ',' . $_SESSION['user_id'] . ')">--</span>');
    } else {
        print('<span id="downvote" class="votebutton" onClick="vote(this.id,' . $topic . ',' . $_SESSION['user_id'] . ')">--</span>');
    }
}

//Checks if the id has voted in this array[topic]
function checkvotes($array, $id)
{
    foreach ($array as $voter) {
        if ($voter == $id) {
            return true;
        }
    }
}

function showpoll($row)
{
    //Middle wrapper to put polls more in middle
    $pollQs = json_decode($row['topic_pollQ']);
    if (!empty($pollQs)) {
        print('<div class="clear"></div><div class="middle-wrapper"><div id="pollcanvas"></div><div>');
        for ($i = 0; $i < count($pollQs); $i++) {
            print '<div><input type="radio" id="radio0' . ($i + 1) . '" name="radio" value="' . ($i + 1) . '" onclick="pollvote(this.value,' . $row['topic_id'] . ',' . $_SESSION['user_id'] . ')"/><label for="radio0' . ($i + 1) . '"><span></span>' . $pollQs[$i] . '</label></div>';
        }
        print('</div></div>');
    }
    $pollAs = json_decode($row['topic_pollA'], true);
    if (!empty($pollAs)) {
        foreach ($pollAs as &$value) {
            if ($value['id'] == $_SESSION['user_id']) {
                echo '<script type="text/javascript">pollvote(' . $value['vote'] . ',' . $row['topic_id'] . ',' . $value['id'] . ');</script><br>';
                break;
            }
        }
    }

}

function getimageengine($row)
{
    $imageconn = create_conn();
    $imagesql = "SELECT * FROM images WHERE image_id = " . $row['topic_image'] . ";";
    $imageresult = $imageconn->query($imagesql);
    if ($imageresult->num_rows > 0) {
        while ($imagerow = $imageresult->fetch_assoc()) {
            print('<div class="fotobox"><img onmouseover="imageajax(this.src)" src="gallery/' . $imagerow['image_filename'] . '" class="foto topicimage"><span onclick="hide(this.id)" class="popuptext hidden" id="imageinfo'.$imagerow['image_filename'].'"></span><br></div>');
        }
    } else {
        print('<div class="fotounavailable">Image unavailable</div>');
    }
    $imageconn->close();
}
