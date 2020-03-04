
//Project 3 JavaScripts

//Running from onclick in the element itself, not fancy but it is just 2 elements.
function vote(div, topic, user) {
    switch (div) {
        case "upvote":
            document.getElementById(div).id = "activeupvote";
            if (document.getElementById("activedownvote")) {
                div += "activedown";
                document.getElementById("activedownvote").id = "downvote";
            }
            break;
        case "activeupvote":
            document.getElementById(div).id = "upvote";
            break;
        case "downvote":
            document.getElementById(div).id = "activedownvote";
            if (document.getElementById("activeupvote")) {
                div += "activeup";
                document.getElementById("activeupvote").id = "upvote";
            }
            break;
        case "activedownvote":
            document.getElementById(div).id = "downvote";
            break;
        default:
            break;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var myobj = parseInt(this.responseText);
            myobj += parseInt(document.getElementById("votes").innerHTML);
            document.getElementById("votes").innerHTML = myobj;
        }
    }
    xmlhttp.open("GET", "votecount.php?topic=" + topic + "&vote=" + div + "&user=" + user, true);
    xmlhttp.send();
}



//Perhaps skip having user identified upvotes/downvotes
//lul no, done
function countvotes(arrayofvotes) {
    var votes = JSON.parse(arrayofvotes);
    return votes.length
}

function suggest(str) {
    if (str.length == 0) {
        document.getElementById("livesearch").innerHTML = "";
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("livesearch").innerHTML = this.responseText;
        }
    }
    xmlhttp.open("GET", "livesearch.php?q=" + str, true);
    xmlhttp.send();
}
/**************************
 * Dynamic topic creation * 
***************************/

//variables for polls to keep track of what's happening
var counter = 1;
var limit = 5;
//Shows textboxes for your poll in makenewtopic
function makepoll() {
    if (counter == 1) {
        //Question 1
        var newdiv = document.createElement('div');
        newdiv.id = "pollrow" + (counter);
        newdiv.innerHTML = "<span class='formName'>Question " + (counter) + " </span>:<input type='text' name='pollrow" + counter + "'><br>";
        document.getElementById("pollInputs").appendChild(newdiv);
        counter++;
        //Question 2
        newdiv = document.createElement('div');
        newdiv.id = "pollrow" + counter;
        newdiv.innerHTML = "<span class='formName'>Question " + (counter) + " </span>:<input type='text' name='pollrow" + counter + "'><br>";
        document.getElementById("pollInputs").appendChild(newdiv);
        document.topic.pollbtn.value = "Remove poll";
        document.getElementById("rowhandler").style.display = "block";
        document.topic.pollamount.value = counter;

    } else {
        //Removes the poll
        document.getElementById("pollInputs").innerHTML = "";
        counter = 1;
        document.topic.pollbtn.value = "Add poll";
        document.getElementById("rowhandler").style.display = "none";
        document.topic.pollamount.value = 1;
    }

}

//Adds/remove more poll questions
function addpollrow() {
    if (counter == limit) {
        alert("Sorry we don't support polls bigger than " + limit + " .");
    }
    else {
        counter++;
        var newdiv = document.createElement('div');
        newdiv.id = "pollrow" + counter;
        newdiv.innerHTML = "<span class='formName'>Question " + (counter) + " </span>:<input type='text' name='pollrow" + counter + "'><br>";
        document.getElementById("pollInputs").appendChild(newdiv);
        document.topic.pollamount.value = counter;

    }
}
function removepollrow() {
    if (counter == 2) {
        alert("Your poll must have atleast 2 questions.");
    }
    else {
        var child = document.getElementById("pollrow" + counter);
        child.parentNode.removeChild(child);
        counter--;
        document.topic.pollamount.value = counter;

    }
}

function pollvote(value, topic, user) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var myobj = this.responseText;
            if (myobj !== "") {
                document.getElementById("pollcanvas").innerHTML = myobj;
            }
        }
    }
    xmlhttp.open("GET", "pollvote.php?topic=" + topic + "&pollvote=" + value + "&user=" + user, true);
    xmlhttp.send();
}

/****************
 * Lets add images to topics!
 *****************/
function updateimg(value) {
    if (value > 0) {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {  // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var myobj = this.responseText;
                if (myobj !== "") {
                    document.getElementById("imgpreview").innerHTML = myobj;
                }
            }
        }
        xmlhttp.open("GET", "getimage.php?image=" + value, true);
        xmlhttp.send();
    }
}
/****************
 * Mouseover on my <images>, load some tiny info from the DB about the image
 *****************/
function imageajax(src) {
    //It's funko-pop! So I get just the filename to send to my database
    var filename = src.split("/").pop();
    var div = document.getElementById("imageinfo" + filename);
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var myobj = this.responseText;
            if (myobj !== "") {
                div.classList.remove("hidden");
                div.classList.add("show");
                div.innerHTML = myobj;
            }
        }
    }
    xmlhttp.open("GET", "getimageinfo.php?image=" + filename, true);
    xmlhttp.send();
}

function hide(id){
    var div = document.getElementById(id);
    div.classList.remove("show");
    div.classList.add("hidden");
}

/*************
 * Sort for homepage
 * **************** */

 function sort(order){
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var myobj = this.responseText;
            if (myobj !== "") {
               document.getElementById("frontpagetopics").innerHTML = myobj;
            }
        }
    }
    xmlhttp.open("GET", "sorttopics.php?order=" + order, true);
    xmlhttp.send();
 }