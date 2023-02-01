<?php 

  include("includes/header.php");

  // if (isset($_POST['submit_article'])) {

  //   $article_name = htmlspecialchars($_POST['article-name']);
  //   $article_type = htmlspecialchars($_POST['article-type']);
  //   $article_content = htmlspecialchars($_POST['FCKeditor']);

  //   echo "<script>alert('". $article_content ."');</script>";

    // mysqli_query($con, "INSERT INTO articles (id, article_name, created_by, date_created, article_description, article_type) VALUES ('', '$article_name', '$userLoggedIn', '$date_created', '$article_content', '$article_type')") or die("Error: " . mysqli_error($con));
    // $last_id = mysqli_insert_id($con);

    // header("Location: articles.php?id=$last_id");
  // }
?>

<div class="container">
  <div class="my-news-feed-title">
    <h1>Write Article</h1>
    <hr>
  </div>
</div>
<br>

<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <!-- <div class="article-create-new">
            <label class="settings-label-account">Article Name</label>
            <input type="text" name="article-name" id="article-name" placeholder="Article Name..." class="settings-input-account">
            <br>
            <br>
            <label class="settings-label-account">Article Type</label>
            <input type="text" name="article-type" id="article-type" placeholder="Article Type..." class="settings-input-account">
            <br>
            <br>
            <textarea id="editor" name="editor" cols="30" rows="10">Enter text here...</textarea>
            <br>
            <input type="hidden" name="created_by" id="created_by" value="<?php echo $userLoggedIn; ?>">
            <p><input type="submit" value="Save" name="submit_article" class="main-button" onclick="submit();" /></p>
            <div id="content" style="display:none;">Saved!</div>
      </div> -->
      <div class="new-article">
          <div class="art-top">
              <h4>Article Name</h4>
          </div>
          <div class="art-detail">
              <div class="body-note">
                  <img src="https://images.pexels.com/photos/2379004/pexels-photo-2379004.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" style="width: 50px; height: 50px; border-radius: 100%;">
                  <strong><a href="#" class="note-name">Name</a></strong>
                  <!-- <input type="text" id="view-general-notes-cat" class="right-btn" name="view-general-notes-cat" placeholder="View category..." style="background-image: url(assets/images/profile_pics/Avatar.png); background-repeat: no-repeat; background-position: left; background-origin: content-box; background-size: 35px 35px;"> -->
                  <input type="text" id="view-general-notes-cat" class="right-btn" name="view-general-notes-cat" placeholder="View category...">
                  <textarea id="editor" name="editor" cols="30" rows="10">Write your article here…</textarea>
              </div>
          </div>
          <div class="art-bottom">
              <p><i class="fa-solid fa-circle-check"></i> &nbsp; &nbsp; Last saved 5mins ago</p>
              <ul class="art-list">
                <li><a href="#"></a><i class="fa-solid fa-share-nodes"></i> Share</li>
                <li><a href="#"></a>Save as Draft</li>
                <li><a href="#"></a>Publish</li>
              </ul>
          </div>
      </div>
    </div>
    <!-- <div class="col-lg-6">
      <div class="new-article-image">
        <img src="https://health-connect.sagraphicswebproofs.co.uk/wp-content/uploads/2021/10/App-build.gif">
      </div>
    </div> -->
  </div>
</div>

<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>

<script>
    var editor=CKEDITOR.replace( 'editor',{
    extraPlugins : 'filebrowser',
    filebrowserUploadMethod:"form",
    filebrowserUploadUrl:"ck_upload.php"
  });

  function submit()
    {
    var article_content = CKEDITOR.instances['editor'].getData();
    var article_name = $('#article-name').val();
    var article_type = $('#article-type').val();
    var created_by = $('#created_by').val();

    $.ajax({
            type: "POST",
            url: "includes/form_handlers/submit_article.php",
            data: "article_name=" + article_name + "&article_type=" + article_type + "&created_by=" + created_by + "&article_content=" + article_content,
            error: function() {
              alert('Error while loading');
          },
          success: function(data) {
            $("#content").show().delay(3000).fadeOut();
          }
      });
}

</script>

<?php 

include("includes/footer.php");

?>