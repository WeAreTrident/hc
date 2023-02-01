
 <?php  

include("includes/header.php");
if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);

    $sql = "SELECT * FROM articles WHERE id = $id";

    $result = mysqli_query($con, $sql);

    $articles = mysqli_fetch_assoc($result);

    mysqli_free_result($result);

    mysqli_close($con);
}

?>

<style>
    .article-single-wrapper {
        background-size: cover;
        background-position: center;
        padding: 150px 50px;
        text-align: center;
        color: white;
        position: relative;
    }

    .article-single-wrapper span {
        position: absolute;
        bottom: 10px;
        left: 20px;
        font-size: 30px;
        color: #8D8A8B;
    }

    .article-single-wrapper h1 {
        font-size: 60px;
        letter-spacing: 3px;
    }

    .article-single-wrapper p {
        color: #8D8A8B;
        font-size: 20px;
    }

    .article-content {
        background: white;
        width: 60%;
        padding: 20px;
        border-radius: 16px;
        margin-top: 20px;
    }

    .article-content h3 {
        color: #8D8A8B;
        font-size: 18px;
    }
</style>


<div class="article-single-wrapper " style="background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.52), rgba(0, 0, 0, 0.73)), url(https://picsum.photos/1400/300); ">
    <h1><?php echo $articles['article_name']; ?></h1>
    <p>@<?php echo $articles['created_by']; ?></p>
    <span><?php echo $articles['article_type']; ?></span>
</div>

<div class="container article-content">
    <h3><?php echo $articles['date_created']; ?></h3>
    <p><?php echo $articles['article_description']; ?></p>
</div>

<br>
<br>


<nav class="navtop">
    <div>
        <h1>Reviews System</h1>
    </div>
</nav>
<div class="content home">
    <h2>Reviews</h2>
    <p>Check out the below reviews for our website.</p>
    <div class="reviews"></div>
    <script>
        const reviews_page_id = 1;
        fetch("reviews.php?page_id=" + reviews_page_id).then(response => response.text()).then(data => {
            document.querySelector(".reviews").innerHTML = data;
            document.querySelector(".reviews .write_review_btn").onclick = event => {
                event.preventDefault();
                document.querySelector(".reviews .write_review").style.display = 'block';
                document.querySelector(".reviews .write_review input[name='name']").focus();
            };
            document.querySelector(".reviews .write_review form").onsubmit = event => {
                event.preventDefault();
                fetch("reviews.php?page_id=" + reviews_page_id, {
                    method: 'POST',
                    body: new FormData(document.querySelector(".reviews .write_review form"))
                }).then(response => response.text()).then(data => {
                    document.querySelector(".reviews .write_review").innerHTML = data;
                });
            };
        });
    </script>
</div>

<style>

.navtop {
    background-color: #3f69a8;
    height: 60px;
    width: 100%;
    border: 0;
}
.navtop div {
    display: flex;
    margin: 0 auto;
    width: 1000px;
    height: 100%;
}
.navtop div h1, .navtop div a {
    display: inline-flex;
    align-items: center;
}
.navtop div h1 {
    flex: 1;
    font-size: 24px;
    padding: 0;
    margin: 0;
    color: #ecf0f6;
    font-weight: normal;
}
.navtop div a {
    padding: 0 20px;
    text-decoration: none;
    color: #c5d2e5;
    font-weight: bold;
}
.navtop div a i {
    padding: 2px 8px 0 0;
}
.navtop div a:hover {
    color: #ecf0f6;
}
.content {
    width: 1000px;
    margin: 0 auto;
}
.content h2 {
    margin: 0;
    padding: 25px 0;
    font-size: 22px;
    border-bottom: 1px solid #ebebeb;
    color: #666666;
}

.reviews .overall_rating .num {
    font-size: 30px;
    font-weight: bold;
    color: #F5A624;
}
.reviews .overall_rating .stars {
    letter-spacing: 3px;
    font-size: 32px;
    color: #F5A624;
    padding: 0 5px 0 10px;
}
.reviews .overall_rating .total {
    color: #777777;
    font-size: 14px;
}
.reviews .write_review_btn, .reviews .write_review button {
    display: inline-block;
    background-color: #565656;
    color: #fff;
    text-decoration: none;
    margin: 10px 0 0 0;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 14px;
    font-weight: 600;
    border: 0;
}
.reviews .write_review_btn:hover, .reviews .write_review button:hover {
    background-color: #636363;
}
.reviews .write_review {
    display: none;
    padding: 20px 0 10px 0;
}
.reviews .write_review textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    height: 150px;
    margin-top: 10px;
}
.reviews .write_review input {
    display: block;
    width: 250px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-top: 10px;
}
.reviews .write_review button {
    cursor: pointer;
}
.reviews .review {
    padding: 20px 0;
    border-bottom: 1px solid #eee;
}
.reviews .review .name {
    padding: 0 0 3px 0;
    margin: 0;
    font-size: 18px;
    color: #555555;
}
.reviews .review .rating {
    letter-spacing: 2px;
    font-size: 22px;
    color: #F5A624;
}
.reviews .review .date {
    color: #777777;
    font-size: 14px;
}
.reviews .review .content {
    padding: 5px 0;
}
.reviews .review:last-child {
    border-bottom: 0;
}
</style>


<?php  

include("includes/footer.php");

?> 
