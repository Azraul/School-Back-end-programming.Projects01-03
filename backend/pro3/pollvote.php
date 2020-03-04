<?php
session_start();
if (isset($_GET['pollvote']) && !empty($_GET['pollvote'])) {
    //Test input so sql is secure
    include 'testinput.php';
    $pollvote = test_input($_GET['pollvote']);
    $user = test_input($_GET['user']);
    $topic = test_input($_GET['topic']);
    //So Kalle can't make Pelle vote
    if ($user == $_SESSION['user_id']) {
        //checks if we should write a new array into the votes
        $freshvote = true;
        //Checks number of votes
        $voteamount = 0;
        //Checks poll options
        $rowstoecho = 0;
        //Colors for canvas
        $canvascolor = "rgb(0,0,255)";
        $votedcolor = "rgb(0,255,0)";
        //Poll values
        $q1 = $q2 = $q3 = $q4 = $q5 = $q6 = 0;
        //include the connect
        include 'connect.php';
        $conn = new mysqli($server, $username, $password, $database);
        $sql = "SELECT topic_pollA, topic_pollQ FROM topics WHERE topic_id = " . $topic . ";";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                //Super problem, decode returns object, true == returns as array (1-2h)
                $newvote = json_decode($row['topic_pollA'], true);
                $rowstoecho = count(json_decode($row['topic_pollQ']));
            }
        }
        //If noone has voted yet, else look if this person has voted
        //If they have voted this loop should find them and change the value
        if (!empty($newvote)) {
            foreach ($newvote as &$value) {
                //Incriment canvas per vote
                //Count amount of votes
                $voteamount++;
                //Change active users vote if there is one
                if ($value['id'] == $user) {
                    $value['vote'] = $pollvote;
                    $freshvote = false;
                }
                //Switch with all poll values that then go into an array later
                switch ($value['vote']) {
                    case 1:
                        $q1++;
                        break;
                    case 2:
                        $q2++;
                        break;
                    case 3:
                        $q3++;
                        break;
                    case 4:
                        $q4++;
                        break;
                    case 5:
                        $q5++;
                        break;
                    case 6:
                        $q6++;
                        break;
                    default:
                        break;
                }
            }
        }
        //If it is a fresh vote
        if ($freshvote == true) {
            $newarray = array("id" => $user, "vote" => $pollvote);
            $newvote[] = $newarray;
            //If you haven't voted we have to increas the result for the frontend!
            switch ($pollvote) {
                case 1:
                    $q1++;
                    break;
                case 2:
                    $q2++;
                    break;
                case 3:
                    $q3++;
                    break;
                case 4:
                    $q4++;
                    break;
                case 5:
                    $q5++;
                    break;
                case 6:
                    $q6++;
                    break;
                default:
                    break;
            }
        }
        //Poll values into an array, called canvas since that's what we will show
        $canvas = makecanvasarray($rowstoecho, $q1, $q2, $q3, $q4, $q5, $q6);
        /**** canvas idea, removed couse of time constraints ******/
        //adjust size of canvas
        //$canvasmodifier = canvasmodifier($voteamount);
        $newvote = json_encode($newvote);
        $sql = "UPDATE topics SET topic_pollA = '$newvote' WHERE topic_id = " . $topic . ";";
        $result = $conn->query($sql);
        if ($conn->affected_rows > 0) {
            for ($i = 0; $i < $rowstoecho; $i++) {
                echo "<span>" . $canvas[$i] . "</span><br>";
                /* Part of canvas idea
            if (($i+1) == $pollvote) {
            echo '<svg viewBox="0 0 100 100" width="' . (1 + $canvas[$i] * $canvasmodifier) . '" height="19"><rect width="30" height="10" style="fill:' . $votedcolor . ';stroke-width:3;stroke:rgb(0,0,0)" /></svg><br>';
            } else {
            echo '<svg viewBox="0 0 100 100" width="' . (1 + $canvas[$i] * $canvasmodifier) . '" height="23"><rect width="30" height="10" style="fill:' . $canvascolor . ';stroke-width:3;stroke:rgb(0,0,0)" /></svg><br>';
            }
             */
            }
        /****If there is no update done, it will still echo the results
         * this also makes it able to show poll results straight away if you have already voted on the poll
         */
        } else {
            for ($i = 0; $i < $rowstoecho; $i++) {
                echo "<span>" . $canvas[$i] . "</span><br>";
            }
        }
        $conn->close();
    }
}
//If no get, redirect back to forum
else {
    header('Refresh:0; url=category.php');
    die();
}

/*** Canvas idea, removed due to time contraints
//Multiplaier for canvases, only adjusted for my 1920x1080
function canvasmodifier($countedvotes)
{
if ($countedvotes < 10) {
$modify = 100;
} elseif ($countedvotes < 100) {
$modify = 10;
} elseif ($countedvotes < 1000) {
$modify =  1;
} else {
$modify =  0.1;
}
return $modify;
}
 */

//Switch that makes the proper "dynamic" array of votes, to avoid errors
function makecanvasarray($votestocanvas, $q1, $q2, $q3, $q4, $q5, $q6)
{
    switch ($votestocanvas) {
        case 2:
            return array($q1, $q2);
            break;
        case 3:
            return array($q1, $q2, $q3);
            break;
        case 4:
            return array($q1, $q2, $q3, $q4);
            break;
        case 5:
            return array($q1, $q2, $q3, $q4, $q5);
            break;
        default:
            return array($q1, $q2, $q3, $q4, $q5, $q6);
            break;
    }
}
