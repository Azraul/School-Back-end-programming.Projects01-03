<?php
if (isset($_GET['vote']) && !empty($_GET['vote'])) {
    //Testa input so sql is secure
    include 'testinput.php';
    $vote = test_input($_GET['vote']);
    $user = test_input($_GET['user']);
    $topic = test_input($_GET['topic']);
    //include the connect
    include 'connect.php';
    $conn = new mysqli($server, $username, $password, $database);
    /***************************    Switch explenation  *************************************
     * Each vote puts your vote into the database
     * AJAX then counts out the new vote, front-end
     * AJAX also changes the id of your voted button to active*vote*
     * ****************************
     * If id active*vote* was pressed it will remove your vote form the database
     * and subtract from the total votes with AJAX
     * ****************************
     * If you voted on something while the other option was active it will remove you from the
     * currently active database, add your new choice to the database and
     * change the ids' of the buttons and count a new vote score with a change of 2 instead of 1
     *          (1 for removing your vote and another for adding to the opposition)
     * with AJAX
     *****************************************************************************************/
    switch ($vote) {
        case "upvote":
            $sql = "SELECT topic_upvote FROM topics WHERE topic_id = " . $topic . ";";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $newvote = json_decode($row['topic_upvote']);
                }
            }
            $newvote[] = $user;
            $newvote = json_encode($newvote);
            $sql = "UPDATE topics SET topic_upvote = '$newvote' WHERE topic_id = " . $topic . ";";
            $result = $conn->query($sql);
            if ($conn->affected_rows > 0) {
                echo 1;
            }
            $conn->close();
            break;
        case "activeupvote":
            $sql = "SELECT topic_upvote FROM topics WHERE topic_id = " . $topic . ";";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $newvote = json_decode($row['topic_upvote']);
                }
            }
            if (($key = array_search($user, $newvote)) !== false) {
                unset($newvote[$key]);
            }
            $newvote = json_encode($newvote);
            $sql = "UPDATE topics SET topic_upvote = '$newvote' WHERE topic_id = " . $topic . ";";
            $result = $conn->query($sql);
            if ($conn->affected_rows > 0) {
                echo -1;
            }
            $conn->close();

            break;
        case "activedownvote":
            $sql = "SELECT topic_downvote FROM topics WHERE topic_id = " . $topic . ";";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $newvote = json_decode($row['topic_downvote']);
                }
            }
            if (($key = array_search($user, $newvote)) !== false) {
                unset($newvote[$key]);
            }
            $newvote = json_encode($newvote);
            $sql = "UPDATE topics SET topic_downvote = '$newvote' WHERE topic_id = " . $topic . ";";
            $result = $conn->query($sql);
            if ($conn->affected_rows > 0) {
                echo 1;
            }
            $conn->close();
            break;

        case "downvote":
            $sql = "SELECT topic_downvote FROM topics WHERE topic_id = " . $topic . ";";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $newvote = json_decode($row['topic_downvote']);
                }
            }
            $newvote[] = $user;
            $newvote = json_encode($newvote);
            $sql = "UPDATE topics SET topic_downvote = '$newvote' WHERE topic_id = " . $topic . ";";
            $result = $conn->query($sql);
            if ($conn->affected_rows > 0) {
                echo -1;
            }
            $conn->close();
            break;
        case "upvoteactivedown":
            $sql = "SELECT topic_downvote FROM topics WHERE topic_id = " . $topic . ";";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $newvote = json_decode($row['topic_downvote']);
                }
            }
            if (($key = array_search($user, $newvote)) !== false) {
                unset($newvote[$key]);
            }
            $newvote = json_encode($newvote);
            $sql = "UPDATE topics SET topic_downvote = '$newvote' WHERE topic_id = " . $topic . ";";
            $result = $conn->query($sql);
            if ($conn->affected_rows > 0) {
                $echo = 1;
            }
            $sql = "SELECT topic_upvote FROM topics WHERE topic_id = " . $topic . ";";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $newvote = json_decode($row['topic_upvote']);
                }
            }
            $newvote[] = $user;
            $newvote = json_encode($newvote);
            $sql = "UPDATE topics SET topic_upvote = '$newvote' WHERE topic_id = " . $topic . ";";
            $result = $conn->query($sql);
            if ($conn->affected_rows > 0) {
                $echo += 1;
                echo $echo;
            }
            $conn->close();
            break;
        case "downvoteactiveup":
            $sql = "SELECT topic_upvote FROM topics WHERE topic_id = " . $topic . ";";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $newvote = json_decode($row['topic_upvote']);
                }
            }
            if (($key = array_search($user, $newvote)) !== false) {
                unset($newvote[$key]);
            }
            $newvote = json_encode($newvote);
            $sql = "UPDATE topics SET topic_upvote = '$newvote' WHERE topic_id = " . $topic . ";";
            $result = $conn->query($sql);
            if ($conn->affected_rows > 0) {
                $echo = -1;
            }
            $sql = "SELECT topic_downvote FROM topics WHERE topic_id = " . $topic . ";";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $newvote = json_decode($row['topic_downvote']);
                }
            }
            $newvote[] = $user;
            $newvote = json_encode($newvote);
            $sql = "UPDATE topics SET topic_downvote = '$newvote' WHERE topic_id = " . $topic . ";";
            $result = $conn->query($sql);
            if ($conn->affected_rows > 0) {
                $echo += -1;
                echo $echo;
            }
            $conn->close();
            break;
        //Just cancel
        default:
            break;
    }

}
//If no get, redirect back to forum
if (empty($_GET)) {
    header('Refresh:0; url=category.php');
    die();
}
?>