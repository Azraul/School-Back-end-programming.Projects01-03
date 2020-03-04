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
<div class="container leftborder">
    <h1>Report for Backend project 3</h1>
    <p> Below comes a report, very basic, for project 3. Include in the bottom is also a changelog (with no time stamps, heresy!) since I used one for this project so I would know what I did</p>
<h2>1.</h2>
<h3>A - Poll</h3>
<p>a.       5pts  - Dynamic poll with up to 5 alternatives.</p>
<p>b.       5pts - User choices show dynamically and they show if you have voted before</p>
<p>c.       5pts - It counts the votes and shows them</p>
<p>d.       5pts(?) -I have missed this line since I makes no sense with my implementation. I dynamically count and show every total value, with this I can dynamically count or show any average or median and don’t need to save a value, JSON was a very good experience, if somewhat time-consuming to learn enough to implement it successfully in under a week.</p>
</div><div class="container leftborder">
<h2>2.</h2>
<h3>a.       Autocomplete suggestions</h3>
<p>i.      10pts – On the search site you should get suggestions from the topic database on titles. So if you search for “p” you should see “Ponies” topic for example.</p>
<h3>b.       Ajax search engine</h3>
<p>i.      5pts – When you make a new topic, you can select an image, a preview of that image is then shown using AJAX and PHP.<br>
        A list of what forum your topic is posted to is also made from the database and it even has an implementation for preselecting what forum you came from when clicking “make new topic”, this was already implemented for project 2.</p>
<p>ii.      5pts - For clicking users, it already had has it’s own a page from project 2. But to further emphasis this constant talk of dynamic all pictures will show a small info text when you mouseover them, collected and built using JS and AJAX/PHP. Click the info boxes to remove them.</p>
<p>iii.      5pts – Implementing it as part of your “blog”, in my case forum. Well yes.</p>
</div><div class="container leftborder">
<h2>3.</h2>
<h3>A – Blog</h3>
<p>a.       5pts – Build a blog, well no it is a forum but you can blog all you want in the blog forum :P</p>
<p>b.       5pts – Where you can make topics with titles</p>
<p>c.       5pts – And they should be sorted with the newest on top</p>
<p>d.       5pts – You should also be able to post replies</p>
</div><div class="container leftborder">
<h2>4.</h2>
<h3>Reddit</h3>
<p>a.       5pts – Upload images is possible</p>
<p>b.       5pts - Saving filename, date and uploader in the database</p>
<p>c.       5pts – On the start page 5 topics are shown</p>
<p>d.       5pts – Users can upvote or downvote, these are updated dynamically and saved in JSON so a user can only vote for up or down.</p>
<p>e.       5pts - You can sort the frontpage for most upvotes or most downvotes</p>
</div><div class="container leftborder">
<h2>5.</h2>
<h3>Report & Feedback</h3>
<p>a.       2pts – Comment the project in a web report, I am.</p>
<p>b.       The good, the bad & the ugly – 3pts</p>
<p>i.      Being able to continue on my previous project 2 was amazing, I could really improve on my old code and since the project got so massive I was really able to feel like I had worked on something. I also really liked the Upvote/Downvote system since I managed to get it very close to reddit in the sense that users are locked to 1 option. The poll assignments had similar effects but I didn’t feel I implemented it as good as I wanted due to time constraints (1 week). My original goal was to have the votes shown using canvas drawings, I got them to work somewhat but they didn’t look the way I wanted and spending precious hours on styling and debugging was skipped for more pressing matters.</p>
<p>ii.      Since I made such a big and open project 2 thanks to the very free “parameters” given and choose to continue for project 3 I felt limited at some points. Like implementing medians/average for no reason or having mouseover events on things just for the reason of having it.</p>
<p>Obviously these complaint can also be summed by the fact that I was feeling time constrained by putting massive amounts in to my JSON projects (2days/8 hours a day) and that I was stubborn and refused to implement jQuery, something I can say I’ve learnt from. If I decide to redo a big project like this again I will definitely not stray from using a JS library.</p>
<p>c.       Improvements – 2pts</p>
<p>i.      A bit time constrained, just 1 week. But it was great that the whole backend course has been mostly down to 1 site during classes that has been improved/reworked, something I truly missed from frontend. Really well structured course overall.</p>
<p>d.       Thoughts during the course – 3pts</p>
<p>i.      What a bloat. I will admit I am somewhat happy with the outcome of my project 2 & 3. But more than the outcome I am happy about having experienced so much during it. Just like after the first web design course I feel like I am now ready to accept a new formula. Starting fresh with markups, logic, css and overall structure. With close to 2000 lines of code and 40 something php files I see the need for a better way to write. It is not that they are inherently bad, they get it all done and I have removed most bugs but I know many functions and files could be combined into “libraries” of their own, to not take about the ease of reading jQuery over pure JS.</p>
<p>On a positive note I can say all my comments have helped, on the first day of this project I spent many hours reworking project 2 and that probably never would have happened if it wasn’t for all the comment work done.</p>
<p>e.       Bonus<p>
<p>i.      Design – My site looks great, as always! kappa</p>
<p>ii.      Ideas – Dynamically growing polls and user locked upvotes!</p>
<p>iii.      Technical solutions and faultless code - JSON</p>
</div>
<div class="container leftborder">
<h2>Change log</h2>
<p>Made engines.php, put all search functions into that and did a major overhaul of categories.php<br>
    Categories now uses functions built in engine.php<p>
<p>Made search site show dynamic auto suggestions from the topics database based on title, with links to the forum topic,
    did however remove user search function since it feelt irrelevant and messed with autocomplete since it showed topics even if you wanted to only see users.
    This is what was needed, there are many improvments to be made but I'd rather work on getting other dynamic functions.<br></p>
<p>Made up and downvotes possible. They should be user locked and you can only vote up or down.<br>
Should lock the votecount.php document to only act it's code if you have xmlhttp request, possible? else redirect?<br>
</p><p>After discussion with the teacher, <b>added test_input()</b> before any sql statements I could find to deal with security flaws.</p>
<p>Added some utf-8 charsets to conns<br>
    JSON_encode also had utf-8 problem, added , JSON_UNESCAPED_UNICODE as fix </p>
<p>Dynamic poll function on newtopic, successfully adds to database<br>
    Polls update dynamicly and are user unique<br>
    Topics currently displays polls<br>
    If you have voted on a topic it will show up straight away, no intentions to add a remove option nor a preshow results</p>
<p>Made image table<br>
    No relationships, since I wanna save images<br>
    You can now upload pictures<br>
    When making a topic, you can pick from the database of images, a preview image shows<br>
    All topics now show images if they have one<br>
    When you mouseover an image a small text popups, that you can close on click, kinda annoying but it's what the speccs say<br>
    Make life simpler next time, use jQuery atleast</p>
<p>Added to homepage 5 oldest topics, you can resort them by Upvotes, Downvotes or latest</p>
<p>Updated live database with images tabel and poll indexes in topics</p>
<p>Page gone live, remeber most new functions requires you to be logged in and to view a specific topic. Edits to topics not available, to make use of new functions please create a new topic</p>
<p>Wrote report, noticed I missed to have forums display topics in descending order</p>
<p>Changed showtopicsbyforum() to send topics in descending order by time</p>
<p>Pushed new version of website to live, on a friday ofcourse</p>
<p>Handed project 3 in as a zip</p>
<p>TGIF, prayed for no bugs then went to get alchol</p>
<p class="signature">Kristoffer Kuvaja Adolfsson 15 March 2019</p>
</div>
<?php
include 'footer.php';
?>