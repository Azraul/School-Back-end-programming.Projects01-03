<?php
session_start();
$page = 'index';
//page variable for active CSS *** Change above on new page && update menu.php ***
include 'header.php';?>

<h1>Welcome to Backend project 3</h1>
<div class="container leftborder">
        <p>This is my 3rd project in backend, it is a continuation on my 2nd project.</p>
        <p>We have to add the ability to upload user content, videos and/or images and then include them in our forum posts.</p>
        <p>The forum from project 2 should be able to include links, polls and upvotes/downvotes it would also be nice to impliment dynamic polls on topics, so you can have more than the required 3 options. Something more on my todo list is to rewrite the code for the main page "categories".</p>
        <p>AJAX is also a large part of this project, we can update the search engines and the admin pages to use AJAX for a smoother experiance. And why not add previews on mouseover for links? (Like wikipedia has)</p>
        <p>The <a href="category.php">forum</a> is still open for anyone, so go ahead and read and if you happen to find something you like, why not <a href="signup.php">register</a> and join in on the fun?<p>
</div>
<div class="container leftborder">
<div class="tag-wrapper">
        <span class="tags" id="Latest" onclick="sort(this.id)">Latest</span><span class="tags" id="Upvotes" onclick="sort(this.id)">Upvotes</span><span class="tags" id="Downvotes" onclick="sort(this.id)">Downvotes</span>
        </div>
</div>
<!---- Can replace this div's content with AJAX ---->
<div id="frontpagetopics">
<?php
include 'engines.php';
$conn = create_conn();
$sql = "SELECT topic_id FROM topics ORDER BY topic_date DESC LIMIT 5";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        showtopic($row['topic_id']);
    }
} else {
    print('<div class="container leftborder">Something is wrong with this topic or it might not exist, try again later.</div>');
}
$conn->close();
?>
</div>
<?php
include 'footer.php';
?>