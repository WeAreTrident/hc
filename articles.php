<?php

include("includes/header.php");

// create a new instance of the article class so that we can use the functions in Article.php
$article = new Article($con, $userLoggedIn);

if (isset($_GET['id'])) {

    if (isset($_POST['rating'], $_POST['content'])) {
        // Insert a new review (user submitted form)

        $article_id = $_GET['id'];
        $user_obj = new User($con, $userLoggedIn);
        $name = $user_obj->getFirstAndLastName();
        $content = $_POST['content'];
        $rating = $_POST['rating'];
        $date_added = date("Y-m-d H:i:s");

        $query = mysqli_query($con, "INSERT INTO reviews (id, name, content, rating, submit_date, article_id) values ('','$name', '$content', '$rating', '$date_added', '$article_id')") or die("Error: " . mysqli_error($con));
        
        header("Location: articles.php?id=$article_id&reviewed=true");
    }

    if ($_GET['reviewed'] == true) {
        echo '
              <script>$(document).ready(function () {
                $("html, body").animate({
                    scrollTop: $(".reviews").offset().top
                }, "slow");
                return false;
            });</script>

        ';
    }

    $article->getArticle($_GET['id']);

?>
<!-- <a href="#" class="main-button">Write Review</a> -->
<div class="write_review">
    <h3>Write a review</h3>
    <form method="POST" action="?id=<?php echo $_GET['id']; ?>">
        <input name="rating" type="number" min="1" max="5" placeholder="Rating (1-5)" required>
        <textarea name="content" placeholder="Write your review here..." required></textarea>
        <br>
        <button type="submit" class="main-button">Submit Review</button>
    </form>
</div>
<br>
<br>    
<?php

}
else {

    if (isset($_GET['author'])) {
        // get articles by author username
        $author = $_GET['author'];

        $articles = $article->getUserArticles($author); ?>

        <div class="container my-news-feed-title">
				<h1>My Articles</h1>
                <br>
                <div class="article-wrapper-search">
                <div class=" wrapper-search-project">
                        <input type="text" id="myFilterMainArticlesUser" class="search-service" onkeyup="myFunctionArticleMainUser()" placeholder="Search for card name...">
                        <i class="fa fa-search fa-lg" aria-hidden="true"></i>
                    </div>
                    <a href="article-create-new.php" class="main-button">Create New Article</a>
                </div>
			</div>
            <br>
<?php
        echo "<div id='myFilterMainArticleUser'><div class='container'><div class='filter-main-articles'><div class='row'> ";
        echo $articles;
        echo "</div></div></div></div>";
    }
    else {
        // list all articles

        ?>  
            <div class="container my-news-feed-title">
				<h1>Articles</h1>
                <hr>
                <div class="article-wrapper-search">
                <div class=" wrapper-search-project">
                        <input type="text" id="myFilterMainArticles" class="search-service" onkeyup="myFunctionArticleMain()" placeholder="Search for card name...">
                        <i class="fa fa-search fa-lg" aria-hidden="true"></i>
                    </div>
                    <a href="article-create-new.php" class="main-button">Create New Article</a>
                </div>
			</div>
            <br>
           
        <?php
        echo "<div id='myFilterMainArticle'><div class='container'><div class='filter-main-articles'><div class='row'> ";
        $article->getAllArticles();
        echo "</div></div></div></div>";
    }


}

?>