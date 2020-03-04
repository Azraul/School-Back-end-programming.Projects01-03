<?php
session_start();
$page = 'report';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>


<!--- Doing a fast style here for readability with just normal html tags
. . . . . . . . . . . . . . . . . . . ________
. . . . . .. . . . . . . . . . . ,.-‘”. . . . . . . . . .``~.,
. . . . . . . .. . . . . .,.-”. . . . . . . . . . . . . . . . . .“-.,
. . . . .. . . . . . ..,/. . . . . . . . . . . . . . . . . . . . . . . ”:,
. . . . . . . .. .,?. . . . . . . . . . . . . . . . . . . . . . . . . . .\,
. . . . . . . . . /. . . . . . . . . . . . . . . . . . . . . . . . . . . . ,}
. . . . . . . . ./. . . . . . . . . . . . . . . . . . . . . . . . . . ,:`^`.}
. . . . . . . ./. . . . . . . . . . . . . . . . . . . . . . . . . ,:”. . . ./
. . . . . . .?. . . __. . . . . . . . . . . . . . . . . . . . :`. . . ./
. . . . . . . /__.(. . .“~-,_. . . . . . . . . . . . . . ,:`. . . .. ./
. . . . . . /(_. . ”~,_. . . ..“~,_. . . . . . . . . .,:`. . . . _/
. . . .. .{.._$;_. . .”=,_. . . .“-,_. . . ,.-~-,}, .~”; /. .. .}
. . .. . .((. . .*~_. . . .”=-._. . .“;,,./`. . /” . . . ./. .. ../
. . . .. . .\`~,. . ..“~.,. . . . . . . . . ..`. . .}. . . . . . ../
. . . . . .(. ..`=-,,. . . .`. . . . . . . . . . . ..(. . . ;_,,-”
. . . . . ../.`~,. . ..`-.. . . . . . . . . . . . . . ..\. . /\
. . . . . . \`~.*-,. . . . . . . . . . . . . . . . . ..|,./.....\,__
,,_. . . . . }.>-._\. . . . . . . . . . . . . . . . . .|. . . . . . ..`=~-,
. .. `=~-,_\_. . . `\,. . . . . . . . . . . . . . . . .\
. . . . . . . . . .`=~-,,.\,. . . . . . . . . . . . . . . .\
. . . . . . . . . . . . . . . . `:,, . . . . . . . . . . . . . `\. . . . . . ..__
. . . . . . . . . . . . . . . . . . .`=-,. . . . . . . . . .,%`>--==``
. . . . . . . . . . . . . . . . . . . . _\. . . . . ._,-%. . . ..`\


-Don't judge or I'll send a word document!  --->
<h1>Report for Backend project 2</h1>
<div class="container leftborder">
I will try to go through each specification for this project and explain how I have fulfilled the requirement. This will in turn makes this report very long.<br>
Original specification in Swedish can be found <a href="BackEnd Projekt 2 - Specs.pdf">here</a>, by Dennis Biström.
</div><div class="admintip"><h4>1.	Plan and specify your databased web application</h4></div>
<div class="container leftborder">
<p><i><b>You can plan a web application:</i></b><br>
As shown on the home page with the <a href="https://cgi.arcada.fi/~kuvajaan/backend/pro2/index.php">siteplan</a>.</p>
<p><i><b>Think about users and user access for different pages:</i></b><br>
The site is open for everyone but creating things is limited to users and creating forums is limited to moderators and admins and only admins can delete forums.</p>
<p><i><b>Document the user interface in the report:</i></b><br>
I went for a very open and easy to read forum, I did limit myself to making sure the page looked good on mainly my own screen with a <b>1920x1080</b> resolution.<br>
I also decided for keeping the page in English as all troubleshooting was done in English and trying to balance Swedish and English in all variables and outputs became too much of a hassle so I’d rather just work in 1 language.</p>
</div><div class="admintip">
<h4>2.	Build the database</h4>
</div><div class="container leftborder">
<div class="start">
<p><b><i>	Think about how many fields are needed and what type those fields are
<br></i></b>	I will say most of this was without thought since we went through most of it on class. Eventually, as I needed quite many tables, I also learnt about foreign keys to make it easy to delete linked posts from said topic. I learnt this from this <a href="https://code.tutsplus.com/tutorials/how-to-create-a-phpmysql-powered-forum-from-scratch--net-10188">guide.</a></p><p>
Hence why most of my database is also built using the same methods described in the guide. I of course also added fields for the required uses of <b>times-visited and last-visited</b>. This also means that adding more features to this forum feels very familiar for example if would be simple to create a int field that printed a user image from a server gallery depending on what number was in that field.
<p><i><b>	Fill some basic data in the database so you can try things. Make use of SELECT, INSERT INTO, UPDATE, DELETE, WHERE, LIKE and ORDER BY.
<br></i></b>	Yes, not sure how I’d make the forum work without them. Also on the <a href="https://cgi.arcada.fi/~kuvajaan/backend/pro2/about.php">about page</a>
I make direct use of ORDER BY to pick the oldest user and the newest topic.
<p><i><b>	Document database structure
<br></i></b>	This <a href="database.svg">picture</a> should provide all tables and their indexes as of February 25, 2019.
</div>
    <div class="end"><a href="database.svg">
    <img class="images" src="database.svg" alt="databaseplan"/></a>
    </div>
</div><div class="admintip">
<h4>3.	Make a PHP login and register</h4>
    </div><div class="container leftborder">
<p><i><b>	Those who visit the page can register, they should have a user name, password, email, join date, last visit to the site, times visited on the site and what their user roll is.
<br></i></b>	You can <a href="https://cgi.arcada.fi/~kuvajaan/backend/pro2/signup.php">register here</a> and try yourself.<br>
You need to enter a unique user name, a password and an email.<br>
Then a joined date, visited date, times visited and roll is saved in the database. Anyone can see their current user level at the bottom of the page and a user can see their data, like time since they joined and last visit at their <a href="https://cgi.arcada.fi/~kuvajaan/backend/pro2/user.php">Mypage</a> from the menu navbar.</p><p>
A guest can also visit the user page, but without a user picked they won’t get any info, however if they click a user name in the forum they can see some basic info about that user and all their made topics, this was some added functionality that I felt compiled to make since a forum needs some kind of user identity.
<p><i><b>	Build the tables needed in the database. Also make use of https://
<br></i></b>	None of this would work if I hadn’t built the database. As for the https:// the main gate to all my backend should now be through https://, however should a user decide to change the url manually I won’t stop them.
<p><i><b>	Save the user password encrypted
<br></i></b>	Saved with hash256 as taught on lectures. Edited passwords, which you can do on <a href="https://cgi.arcada.fi/~kuvajaan/backend/pro2/user.php">Mypage</a> are also saved with hash256.
</div><div class="admintip"><h4>4.	Present the database for you chief</h4>
</div><div class="container leftborder">
<p><i><b>	Make a PHP-application that lists all relevant information from a table in a “nice” format.
<br></i></b>	This is what the <a href="https://cgi.arcada.fi/~kuvajaan/backend/pro2/about.php">about page</a> is for.<br>
As a forum I feel it is most relevant to post the <b>amount</b> of users, forums, topics and replies. I also feel it could be a selling point to show when the latest topic was made to prove how “active” our forum is and how old our oldest member is. It is detailed in seconds since a forum needs to troll.
</div><div class="admintip"><h4>5.	Insert data in the database</h4>
</div><div class="container leftborder">
<p><i><b>	Make a PHP application that makes it easy to insert fast and conveniently ( ͡° ͜ʖ ͡°) into the database.
<br></i></b>	Well you can make <a href="https://cgi.arcada.fi/~kuvajaan/backend/pro2/newreply.php">posts</a> and <a href="https://cgi.arcada.fi/~kuvajaan/backend/pro2/newtopic.php">topics</a> as a user and it is rather convenient since if you go from a forum and make the topic with the <i>make a topic</i> button the form for making a topic will remember what forum you where viewing and pick it by default.
<p><i><b>	Choose one or more tables where it is logical to insert data
<br></i></b>	All of them, depending on the user level of course.
<p><i><b>	Only allow insert if you are registered
<br></i></b>	I have tried making topics as a guest and it wouldn’t let me, can’t believe how rude this forum is.
</div><div class="admintip"><h4>6.	Change information in the database</h4>
</div><div class="container leftborder">
<p><i><b>	Make a PHP application that allows changes to be made to existing database elements.
<br></i></b>	That is why all <a href="https://cgi.arcada.fi/~kuvajaan/backend/pro2/editpost.php">posts</a> and <a href="https://cgi.arcada.fi/~kuvajaan/backend/pro2/edittopic.php">topics</a> have an EDIT button if you are the creator of the element and if you are the creator it might even let you change it.
Did I mention you can also edit your password on <a href="https://cgi.arcada.fi/~kuvajaan/backend/pro2/user.php">Mypage</a> as a user?
</div><div class="admintip"><h4>7.	Remove data from the database</h4>
</div><div class="container leftborder">
<p><i><b>	Make a PHP application that allows data to be removed from the database
<br></i></b>	All <a href="https://cgi.arcada.fi/~kuvajaan/backend/pro2/deletepost.php">posts</a> and <a href="https://cgi.arcada.fi/~kuvajaan/backend/pro2/deletetopic.php">topics</a> have a DELETE button if you are the creator of the element and if you are the creator it might even let you. Just remember that deleting a topic will delete all associated posts thanks to the foreign key that cascades on deletion.
Admins can also DELETE forums with all associated topics and posts from the admin page or just separate topics/posts from the admin page.
<p><i><b>	Verify the information the user wants to delete
<br></i></b>	When you press the DELETE button you should be taken to a separate site that shows the element you want to delete, when you press the DELETE button on that site you get an alert warning you about the deletion to happen. Then if you are the creator or an admin, and only then, should the element be deleted from the database.
</div><div class="admintip"><h4>8.	Search in the database</h4>
</div><div class="container leftborder">
<p><i><b>	Add a google search box and make sure you don’t search in any other way than through google since they want your data.
<br></i></b>	Okey here: Göögle.com
<p><i><b>	Make a flexible text-based PHP search engine that can look up posts
<br></i></b>	<a href="https://cgi.arcada.fi/~kuvajaan/backend/pro2/search.php">Search tab</a> in the menu.
You can search topics, posts or both for “text” in the content or topic or topics and posts by a user. For extra spice if you search for a user you must match their name fully since we don’t want any guests going around and stalking our members too easy, they need to be <i>professional stalkers</i>.
<p><i><b>	Search from some of the databases tables
<br></i></b>	Read above.
</div><div class="admintip"><h4>9.	Administration and user interface</h4>
</div><div class="container leftborder">
<p><i><b>	Make a admin interface where you can administer users<br> - and other tables in the database
<br></i></b>	The <a href="https://cgi.arcada.fi/~kuvajaan/backend/pro2/admin.php">admin page</a>, that you only get to view in its full glory if you are an admin, lets you use the search engine to find topics and/or posts and delete them or you could change a user’s email.</p><p> The search here differs in that it finds all users that matches any part of the search and by not saving your previous your search in the search form. Also deleting users is not in this forums interest, hence it is unavailable, totally NOT in-line with the latest EU regulations, sue me please!
</div><div class="admintip"><h4>10.	Reflections and feedback</h4>
</div><div class="container leftborder">
<p><i><b>	This project has more freedom than usual so you have more to explain.
<br></i></b>	I changed my report layout to reflect this, going over all points separately. Is it better like this?
<p><i><b>	Notice that in specification assignment you should paint a structured plan for what you planned to do
<br></i></b>	My <a href="https://cgi.arcada.fi/~kuvajaan/backend/pro2/index.php">specification</a> is rather adequate, there was some points that got name changes, posts to topics and replies to posts and some points didn’t make it into the final product like moderators being able to lock topics.</p>
<p> The idea to have them being able to lock threads was something I left for later but never got around to. The theory behind would be to add another index to topics, a small int value (topic_locked as a Boolean), then an if statement would be put into the while loops of the category page and search page and if the topic_locked is true it could simple not print that <b>$row</b>. The locked topic would still be visible for admins in the admin page with a separate topic search engine that only brought up the topics with topic_locked = true so they can delete the topic. A user however that manipulated their url with the topic value would of course still be able to view this topic until an admin or the creating user or an admin deleted it, which I think is fair since the forum is supposed to be open.</p>
<p>In a similar way user_level could be changed to make level 0 a banned/unregistered user and if the email service was properly implemented a randomly generated URL, like the random passwords from backend project 1 could be sent to the users email and stored in a new user index and if they clicked the link it a <b>$_GET</b> request is run and the user_level is increased to active and the randomly generated code from the database is changed to NULL or verified for example.
<p><i><b>	Explain more about you choices earlier and comment to all assignments where you could pick indexes to your database.
<br></i></b>	Categories have an id that links to topic and topics have an id that links to posts, so that you can print associated posts to topics and topics to categories. Topics and posts both have an id that links to users id so you know who created the topic/post.</p>
<p>Most of this came automatically when I worked with the <a href="https://code.tutsplus.com/tutorials/how-to-create-a-phpmysql-powered-forum-from-scratch--net-10188">guide</a> mentioned earlier.
The guide also creates the foreign links discussed earlier and where a real eye opener when I tried to write sql that deleted from multiple tables in one line but then realized I didn’t have to since they where linked.</p>
<p>The users table also has a index that increases every time on login and 3 date values, one for creation, one for login and one for last login. The user_date is set at creation together with a new_visit since, well, you are visiting the forum if you are creating a user for yourself.</p>
<p>The previous visit is then replaced with the current visit each time you login. So if you login on a Monday it is saved in new_visit, when you then login on Tuesday the new_visit is saved to a variable and this variable gets put into replaces last_visit (so now last_visit is Monday) and new_visit becomes Tuesday. Meaning we can select last_visit on <a href="https://cgi.arcada.fi/~kuvajaan/backend/pro2/user.php">Mypage</a> and see when you logged in last time.
    </div><div class="admintip"><h4>My reflections</h4>
</div><div class="container leftborder">
Well as with last time we had a more open assignment I took quite a lot of liberty.<br>
The classes in backend for this project have been efficient in viable knowledge, almost setting the whole project to completion within lecture hours. Because of this I could put in extra effort and explore new areas.</p>
<p>Making this forum took quite the effort but I feel it really paid off. Now that we could structure a somewhat proper login system with users it was also made possible to regulate them with sessions properly and everything felt realistic.</p>
<p>It also feels very real to look at my forum and see all the things that could be implemented that other forums have. Its also clearly visible to see some improvements I made during this project in my code. When I started, I made different PHP applications for forms and inserting them into the database. In the latter stages of development I was able to make the logic for the whole process in just one page.</p>
<p>I also realize the need for a good structure, for example, as I neared completion of the project, I wanted to stylize all error messages and realized that include elements would have made this process so much simpler and the code much shorter. Even adding a variable like I have for my menu system where the variable could be a custom message automatically printed by the included code, something for the future.</p>
<p>While looking to the future I think having open projects from time to time is a great motivator, though not all the time since no one wants a burnout. This project has especially benefited from all the lectures being efficient enough to give all the needed knowledge and no matter the final verdict this project has been a big win for me as student.</p>
<p class="signature">Kristoffer Kuvaja Adolfsson 26 Februari 2019</p>
</div>
<?php
include 'footer.php';
?>