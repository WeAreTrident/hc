
<?php

require_once('includes/calendar_functions.php');

// doInitialGoogleSync();
// doGoogleSync();
// doInitialMicrosoftSync();
// doMicrosoftSync();

if(isSet($_FILES['ics']) && strtolower(trim(end((explode(".", $_FILES['ics']['name']))))) == 'ics' && $_FILES['ics']['type'] == 'text/calendar') {
  importICSFile(file_get_contents($_FILES['ics']['tmp_name']));
}

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

#sortable1, #sortable2, #sortable3, #sortable4, #sortable5 {
border: 1px solid #eee;
width: 100%;
min-height: 40px;
list-style-type: none;
/*margin: 0;*/
padding: 0px;
/* float: left;*/
margin-right: 10px;
border-radius: 16px;
}
#sortable1 li, #sortable2 li, #sortable3 li, #sortable4 li, #sortable5 li {
/* border: 1px solid black;*/
/*padding: 5px;*/
font-size: 1.2em;
width: 100%;
border-radius: 16px;
background: var(--widget-background);
box-shadow: 0px 0px 11px 2px #e5e9e6;
}

li.calendar.ui-sortable-handle {
/*height: 500px;*/
}

li.my-team.ui-sortable-handle {
/*height: 150px;*/
}

li.banner-page.ui-sortable-handle {
/*height: 70px;*/
}

li.ui-state-default.ui-sortable-handle {
/*height: 700px;*/
}


.posts_area {
height: 900px;
overflow: scroll;
margin-top: 20px;
margin-bottom: 20px;
}

.posts_area::-webkit-scrollbar {
-webkit-appearance: none;
width: 10px;
}

.posts_area::-webkit-scrollbar-thumb {
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
  $( "#sortable1, #sortable2, #sortable3, #sortable4, #sortable5" ).sortable({
    connectWith: ".connectedSortable"
  }).disableSelection();
} );
</script>

<br>
<br>
<div class="container">
  <div class="row">
    <div class="col-lg-7">
      <ul id="sortable1" class="connectedSortable">
        <li class="banner-page">
          <div class="welcome-back">
            <h2>Welcome back,</h2> <a href="<?php echo $userLoggedIn; ?>"><?php echo $user['first_name'] . " " . $user['last_name']; ?></a>
          </div>
          <div class="nice-day-work">
            <p>Have a nice day at work.</p>
          </div>
        </li>
      </ul>
      <div class="row">
        <div class="col-lg-6 col-md-6">
          <ul id="sortable2" class="connectedSortable">
            <li class="my-team">
              <div class="jobs-content-1">
                <div class="row">
                  <div class="col-sm-12 col-md-6">
                    <h2>My Team</h2>
                    <p>15 Members</p>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="my-teams-align">
                      <div class="images-my-teams">
                        <img src="https://images.unsplash.com/photo-1542178243-bc20204b769f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1480&q=80" width="40" height="40">
                        <img src="https://images.unsplash.com/photo-1631680900243-3c207cf5a481?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1480&q=80" width="40" height="40">
                        <img src="https://images.unsplash.com/photo-1578635073855-a89b3dd5cc18?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1480&q=80" width="40" height="40">
                        <img src="https://images.unsplash.com/photo-1627393100177-b4297e79a5be?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1480&q=80" width="40" height="40">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="text-right">
                    <a href="#" class="main-button-nw">+ Add a new patient</a>
                </div>
              </div>
            </li>
          </ul>
        </div>
        <div class="col-lg-6 col-md-6">
          <div class="appointment-box">
            <h2 class="text-center ">My Appointments</h2>
            <table class="apppoint-table">
                <tr role="row">
                    <td>02.03.2022</td>
                    <td>Appointment Name</td>
                    <td>13.00</td>
                    <td class="join"><div class="join-tab"><i class="fa-solid fa-video"></i> Join</div></td>
                </tr>
                <tr role="row">
                    <td>02.03.2022</td>
                    <td>Appointment Name</td>
                    <td>13.00</td>
                    <td class="join"><div class="join-tab"><i class="fa-solid fa-video"></i> Join</div></td>
                </tr>
                <tr role="row">
                    <td>02.03.2022</td>
                    <td>Appointment Name</td>
                    <td>13.00</td>
                    <td class="join"><div class="join-tab"><i class="fa-solid fa-video"></i> Join</div></td>
                </tr>
            </table>
            <div class="more"><i class="fa-solid fa-plus"></i></div>
          </div>
        </div>
        <ul id="sortable7" class="connectedSortable">
          <!-- <li class="ui-state-default">
            <div class="banner-news-feed">
              <h2>News Feed</h2>
            </div>
            <div class="recent-feed-activity">
              <form class="post_form" action="index.php" method="POST" enctype="multipart/form-data">
                <textarea class="textarea-field-profile" name="post_text" id="input22" placeholder="Got something to say?"></textarea>
                <br>
                <div id="users22" class="users">
                  <ul class="list22"></ul>
                </div>
                <div class="file-align-index">
                  <div class='file-input'>
                    <input type="file" name="fileToUpload" id="fileToUpload" />
                    <span class='button'>Choose</span>
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
                    </script>
                    <br>
                    <button type="submit" name="post" class="main-button">Post</button>
                </div>
              </form>
              <div class="posts_area"></div>
              <div style="text-align: center;"><img src="assets/images/icons/loading.gif" id="loading" /></div>
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
                          data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
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
          </li> -->
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
                      <a href="#" class="first">+ Document</a>
                      <a href="#">+ Video</a>
                      <a href="#">+ Image</a>
                      <a href="#">+ Article</a>
                      <button type="submit" name="post" class="feed-button">Post</button>                
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
            <!-- <div class="posts_area"></div> -->
              <!-- <div style="text-align: center;">
                <img src="assets/images/icons/loading.gif" id="loading" />
              </div> -->
            <div class="feed-com">
              <div class="feed-top">
                <img src="<?php echo $user['profile_pic']; ?>" alt="<?php echo $user['first_name'] . ' ' . $user['last_name']; ?>" style="width:50px; height:50px; border-radius: 100%;">
                <p><span>Caption  date /time</span>
                <strong><?php echo $user['first_name']." ".$user['last_name']; ?></strong></p>
              </div>
              <div class="feed-content">
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                  <img src="/assets/images/posts/feed.png" class="img-fluid">
                  <div class="banner-overlay">
                      <p>Lorem ipsum dolor sit amet, consectetur<br> adipiscing elit, sed do eiusmo</p>
                      <a href="#">Read Article</a>
                  </div>
              </div>
              <div class="feed-bottom">
                  <p class="text-left">42 reactions</p>
                  <p class="text-right">11 comments<!-- <span>2 shares</span> --></p>
              </div>
              <div class="feed-social">
                  <a href="#" class="first"><i class="fa-solid fa-lightbulb-on"></i></a>
                  <a href="#"><i class="fa-solid fa-badge-check"></i></a>
                  <a href="#"><i class="fa-solid fa-thumbs-up"></i></a>
                  <a href="#"><i class="fa-solid fa-heart"></i></a>
                  <a href="#"><i class="fa-solid fa-thought-bubble"></i></a>
                  <a href="#" class="big-btn">Comment</a>
                  <!-- <a href="#" class="big-btn last">Share</a> -->
              </div>
            </div>
            <div class="feed-com">
              <div class="feed-top">
                <img src="<?php echo $user['profile_pic']; ?>" alt="<?php echo $user['first_name'] . ' ' . $user['last_name']; ?>" style="width:50px; height:50px; border-radius: 100%;">
                <p><span>Caption  date /time</span>
                <strong><?php echo $user['first_name']." ".$user['last_name']; ?></strong></p>
              </div>
              <div class="feed-content">
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                  <img src="/assets/images/posts/feed.png" class="img-fluid">
                  <div class="banner-overlay">
                      <p>Lorem ipsum dolor sit amet, consectetur<br> adipiscing elit, sed do eiusmo</p>
                      <a href="#">Read Article</a>
                  </div>
              </div>
              <div class="feed-bottom">
                  <p class="text-left">42 reactions</p>
                  <p class="text-right">11 comments<!-- <span>2 shares</span> --></p>
              </div>
              <div class="feed-social">
                  <a href="#" class="first"><i class="fa-solid fa-lightbulb-on"></i></a>
                  <a href="#"><i class="fa-solid fa-badge-check"></i></a>
                  <a href="#"><i class="fa-solid fa-thumbs-up"></i></a>
                  <a href="#"><i class="fa-solid fa-heart"></i></a>
                  <a href="#"><i class="fa-solid fa-thought-bubble"></i></a>
                  <a href="#" class="big-btn">Comment</a>
                  <!-- <a href="#" class="big-btn last">Share</a> -->
              </div>
            </div>
            <!-- <script>
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
            </script> -->
          </li>
        </ul>
      </div>
    </div>
    <div class="col-lg-3">
      <ul id="sortable5" class="connectedSortable">
        <li class="calendar">
          <div class="card-cal">
            <div class="calendar-toolbar">
              <button class="prev month-btn"><i class="fas fa-chevron-left"></i></button>
              <div class="current-month"></div>
              <button class="next month-btn"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="calendar">
              <div class="weekdays">
                <div class="weekday-name">Sa</div>
                <div class="weekday-name">Su</div>
                <div class="weekday-name">Mo</div>
                <div class="weekday-name">Tu</div>
                <div class="weekday-name">We</div>
                <div class="weekday-name">Th</div>
                <div class="weekday-name">Fr</div>
              </div>
              <div class="calendar-days"></div>
            </div>
            <div class="goto-buttons">
              <button type="button" class="btn-cal prev-year">Prev Year</button>
              <button type="button" class="btn-cal today">Today</button>
              <button type="button" class="btn-cal next-year">Next Year</button>
            </div>
          </div>
          <br>
          <br>
          <div id="calendar-events-list"></div>
          <br>
        </li>
      </ul>
    </div>
  </div>
</div>

      <style>
        :root {
            --color-accent: rgb(112, 71, 235);
            --background-color: #f8f7fa;
            --foreground-color: #ffffff;
            --text-color: #19181a;
            --highlight-text-color: var(--text-color);
            --active-text-color: #f8f7fa;
            --inactive-text-color: #a5a5a5;
            --btn-bg: #f8f7fa;
            --box-shadow: #efefef;

            --border-width: 1px;
            --border-radius: 15px;
            --spacing: 18px;
          }

          @media (prefers-color-scheme: dark) {
            :root {
              --background-color: #19181a;
              --foreground-color: #282729;
              --text-color: #c9c8cc;
              --highlight-text-color: #f8f7fa;
              --inactive-text-color: #68676a;
              --btn-bg: #313133;
              --box-shadow: #111111;
            }
          }

          .card-cal {
            /* width: 316px; */
            height: fit-content;
            background-color: var(--foreground-color);
            border-radius: var(--border-radius);
            /* box-shadow: 0px 0px 10px var(--box-shadow); */
            padding-top: 40px;
          }

          .calendar-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            padding-bottom: 15px;
            /* border-bottom: var(--border-width) solid var(--box-shadow); */
          }

          .calendar-toolbar > .current-month {
            font-size: 20px;
            font-weight: bold;
            color: var(--highlight-text-color);
          }

          .calendar-toolbar > [class$="month-btn"] {
            width: 40px;
            height: 40px;
            aspect-ratio: 1;
            text-align: center;
            line-height: 40px;
            font-size: 14px;
            color: var(--highlight-text-color);
            background: #49BEFF;
            border: none;
            border-radius: 60px;
          }

          .month-btn i {
            color: white;
          }

          .weekdays,
          .calendar-days {
            display: flex;
            flex-wrap: wrap;
            padding-inline: var(--spacing);
          }
          .weekdays {
            padding-top: 12px;
            width: 95%;
            margin: auto;
          }
          .calendar-days {
            padding-bottom: 12px;
            width: 95%;
            margin: auto;
          }

          .weekday-name,
          [class$="-day"] {
            width: 14.28%;
            height: 40px;
            color: var(--text-color);
            text-align: center;
            line-height: 40px;
            font-weight: 500;
            font-size: 1rem;
          }

          .weekday-name {
            color: var(--highlight-text-color);
            font-weight: 700;
          }

          .current-day {
            background-color: #49BEFF;
            color: var(--active-text-color);
            border-radius: 40px;
            font-weight: 700;
            transition: 0.5s;
            cursor: pointer;
            width: 10%;
            height: 40px;
            margin: auto;
          }

          .padding-day {
            color: var(--inactive-text-color);
            user-select: none;
          }

          .calendar-toolbar > [class$="month-btn"]:hover,
          .month-day:hover,
          .btn-cal:hover {
            border-radius: 90px;
            /* background-color: var(--btn-bg); */
            color: #49BEFF;
            opacity: 0.6;
            transition: 0.1s;
            cursor: pointer;
          }
      </style>