<?php

$provider_obj = new User($con, $userLoggedIn);
$provider_name = $provider_obj->getProviderName($userLoggedIn);

  if (isset($_POST['post'])) {

  $uploadOk = 1;
  $imageName = $_FILES['fileToUpload']['name'];
  $errorMessage = "";

  if($imageName != "") {
    $targetDir = "assets/images/posts/";
    $imageName = $targetDir . uniqid() . basename($imageName);
    $imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);

  if($_FILES['fileToUpload']['size'] > 10000000) {
    $errorMessage = "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  if(strtolower($imageFileType) != "jpeg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpg") {
    $errorMessage = "Sorry, only jpeg, jpg and png files are allowed.";
    $uploadOk = 0;
  }

  if($uploadOk) {
    if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageName)) {
      // image uploaded ok
    }
    else {
      // image did not upload
      $uploadOk = 0;
    }
  }
}

if($uploadOk) {
  $post = new Post($con, $userLoggedIn);
  $post->submitPost($_POST['post_text'], 'none');
}
else {
  echo "<div style='text-align:center;' class='alert alert-danger'>
  $errorMessage
  </div>";
}
}

?>

<style>
    #sortable6, #sortable7, #sortable8, #sortable9 {
      border: 1px solid #eee;
      width: 100%;
      min-height: 60px;
      list-style-type: none;
      /*margin: 0;*/
      padding: 0px;
     /* float: left;*/
      margin-right: 10px;
      border-radius: 16px;
    }
    #sortable6 li, #sortable7 li, #sortable8 li, #sortable9 li {
     /* border: 1px solid black;*/
      /*padding: 5px;*/
      font-size: 1.2em;
      width: 100%;
      border-radius: 16px;
      background: white;
      box-shadow: 0px 0px 11px 2px #e5e9e6;
    }
    .service-card-grid::-webkit-scrollbar {
      -webkit-appearance: none;
      width: 10px;
    }

    .service-card-grid::-webkit-scrollbar-thumb {
        border-radius: 5px;
        background: linear-gradient(
      129deg, rgba(73,190,255,1) 0%, rgba(128,72,255,1) 100%);
        -webkit-box-shadow: 0 0 1px rgba(255,255,255,.5);
      }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

<script>
  $( function() {
    $( "#sortable5, #sortable6, #sortable7, #sortable8, #sortable9" ).sortable({
      connectWith: ".connectedSortable"
    }).disableSelection();
  } );
</script>

<div class="staff-dashboard">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6">
        <ul id="sortable2" class="connectedSortable">
          <li class="my-team">
            <div class="jobs-content-1">
              <h2>My Colleagues</h2>
              <div class="my-teams-align">
                <div class="images-my-teams"> 
                  <img src="https://images.unsplash.com/photo-1542178243-bc20204b769f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1480&q=80" width="40" height="40"> 
                  <img src="https://images.unsplash.com/photo-1631680900243-3c207cf5a481?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1480&q=80" width="40" height="40"> 
                  <img src="https://images.unsplash.com/photo-1578635073855-a89b3dd5cc18?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1480&q=80" width="40" height="40"> 
                  <img src="https://images.unsplash.com/photo-1627393100177-b4297e79a5be?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1480&q=80" width="40" height="40"> 
                </div>
                <p>15 Colleagues</p>
              </div>
            </div>
          </li>
        </ul>
      </div>
      <div class="col-lg-6 col-md-6">
        <ul id="sortable3" class="connectedSortable">
          <li class="my-team">
            <div class="notifications-content-1">
              <h2>My Service Users</h2>
              <div class="my-teams-align">
                <div class="images-my-teams"> <img src="https://images.unsplash.com/photo-1542178243-bc20204b769f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1480&q=80" width="40" height="40"> <img src="https://images.unsplash.com/photo-1631680900243-3c207cf5a481?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1480&q=80" width="40" height="40"> <img src="https://images.unsplash.com/photo-1578635073855-a89b3dd5cc18?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1480&q=80" width="40" height="40"> <img src="https://images.unsplash.com/photo-1627393100177-b4297e79a5be?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1480&q=80" width="40" height="40"> </div>
                <p>15 Users</p>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="col-md-7">
        <ul id="sortable7" class="connectedSortable feed-sec">
         <li>
          <div class="upper-sec">
            <div class="banner-news-feed">
              <h2 class="post-feed">Write a post</h2>
            </div>
            <div class="recent-feed-activity">
              <div class="newsfeed-post">
                <div class="feed-top">
                  <img src="<?php echo $user['profile_pic']; ?>" alt="<?php echo $user['first_name'] . ' ' . $user['last_name']; ?>" style="width:50px; height:50px; border-radius: 100%;"> <strong><?php echo $user['first_name']." ".$user['last_name']; ?></strong>
                </div>
                <form class="post_form" action="index.php" method="POST" enctype="multipart/form-data">
                  <textarea class="textarea-field-profile" name="post_text" id="input22" placeholder="Write your post here..."></textarea>
                  <div class="newsfeed-actions">
                    <a href="#" class="col first">+ Document</a>
                    <a href="#" class="col">+ Video</a>
                    <a href="#" class="col">+ Image</a>
                    <a href="#" class="col">+ Article</a>
                    <a type="submit" name="post" class="feed-button col">Post</a>                
                  </div>
                  <div id="users22" class="users">
                    <ul class="list22"></ul>
                  </div>
                      <!-- <div class="file-align-index">
                      <div class='file-input'>
                        <input type="file" name="fileToUpload" id="fileToUpload" />
                          <span class='button'>+ Document</span>
                          <span class='button'>+ Video</span>
                          <span class='button'>+ Image</span>
                            <span class='label' data-js-label>No file selected</label>
                      </div>
                      <script>
                        // Also see: https://www.quirksmode.org/dom/inputfile.html

                        var inputs = document.querySelectorAll('.file-input')

                        for (var i = 0, len = inputs.length; i < len; i++) {
                          customInput(inputs[i])
                        }

                        function customInput (el) {
                          const fileInput = el.querySelector('[type="file"]')
                          const label = el.querySelector('[data-js-label]')
                          
                          fileInput.onchange =
                          fileInput.onmouseout = function () {
                            if (!fileInput.value) return
                            
                            var value = fileInput.value.replace(/^.*[\\\/]/, '')
                            el.className += ' -chosen'
                            label.innerText = value
                          }
                        }
                      </script> -->
                </form>
              </div>
            </div>
          </div>
            <div class="posts_area"></div>
              <div style="text-align: center;">
                <img src="assets/images/icons/loading.gif" id="loading" />
              </div>

            <script>
              $(function(){ 
               
                var userLoggedIn = '<?php echo $userLoggedIn; ?>';
                var inProgress = false;
               
                loadPosts(); //Load first posts
               
                  $(window).scroll(function() {
                    var bottomElement = $(".status_post").last();
                    var noMorePosts = $('.posts_area').find('.noMorePosts').val();
               
                      // isElementInViewport uses getBoundingClientRect(), which requires the HTML DOM object, not the jQuery object. The jQuery equivalent is using [0] as shown below.
                      if (isElementInView(bottomElement[0]) && noMorePosts == 'false') {
                          loadPosts();
                      }
                  });
               
                  function loadPosts() {
                      if(inProgress) { //If it is already in the process of loading some posts, just return
                    return;
                  }
                  
                  inProgress = true;
                  $('#loading').show();
               
                  var page = $('.posts_area').find('.nextPage').val() || 1; //If .nextPage couldn't be found, it must not be on the page yet (it must be the first time loading posts), so use the value '1'
               
                  $.ajax({
                    url: "includes/handlers/ajax_load_posts.php",
                    type: "POST",
                    data: "page=" + page + "&userLoggedIn=" + userLoggedIn + "&provider=<?php echo $provider_name; ?>",
                    cache:false,
               
                    success: function(response) {
                      $('.posts_area').find('.nextPage').remove(); //Removes current .nextpage 
                      $('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage 
                      $('.posts_area').find('.noMorePostsText').remove(); //Removes current .nextpage 
               
                      $('#loading').hide();
                      $(".posts_area").append(response);
               
                      inProgress = false;
                    }
                  });
                  }
               
                  //Check if the element is in view
                  function isElementInView (el) {
                      var rect = el.getBoundingClientRect();
               
                      return (
                          rect.top >= 0 &&
                          rect.left >= 0 &&
                          rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && //* or $(window).height()
                          rect.right <= (window.innerWidth || document.documentElement.clientWidth) //* or $(window).width()
                      );
                  }
              });
            </script>
         </li>
        </ul>
      </div>
      <div class="col-md-5">
        <ul id="sortable9" class="connectedSortable">
          <li>
            <div class="banner-news-feed">
              <h2>Document Store</h2>
            </div>
            <div class="wrapper-doc-store">
              <div class="document-store-provider container">
                <?php
                  $docs_obj = new Document($con, $userLoggedIn);
                  $docs = $docs_obj->getDocuments($userLoggedIn, "profile");
                  echo $docs;
                ?>
              </div>
            </div>
            <div class=" contact-service" >
              <a href="documents.php" class="main-button">View All</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
