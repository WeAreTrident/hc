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
<br>
<br>
<div class="container">
  	<div class="row">
	    <div class="col-lg-12">
			 <ul id="sortable6" class="connectedSortable">
			   <li class="select-a-service">
			   	  <div class="banner-news-feed">
        			<h2>Select a Service</h2>
      			</div>
            <div class="container wrapper-spacing-search">
              <div class="wrapper-search-service">
                <input type="text" id="myFilter" class="search-service" onkeyup="myFunction()" placeholder="Search services...">
              </div>
              <a href="#" class="main-button">View All</a>
            </div>
            <div class="service-card-grid" id="myServices">
              <?php
                $query = mysqli_query($con, "SELECT * FROM services WHERE provider_id='$userLoggedIn'");
                while ($row = mysqli_fetch_array($query)) {
              ?>
                <a class="card-link-service" href="selected-service.php?id=<?php echo $row['id']; ?>">
  	      				<div class="card-service">
  	      					<img src="<?php echo $row['image']; ?>">
  	      					<h3 class="card-title"><?php echo $row['service_name']; ?></h3>
  	      					<p><?php echo $row['service_location']; ?></p>
  	      				</div>
                </a>
              <?php } ?>
              <script>
                function myFunction() {
                  var input, filter, cards, cardContainer, title, i;
                  input = document.getElementById("myFilter");
                  filter = input.value.toUpperCase();
                  cardContainer = document.getElementById("myServices");
                  cards = cardContainer.getElementsByClassName("card-link-service");
                  for (i = 0; i < cards.length; i++) {
                    title = cards[i].querySelector(".card-title");
                    if (title.innerText.toUpperCase().indexOf(filter) > -1) {
                      cards[i].style.display = "";
                    } else {
                      cards[i].style.display = "none";
                    }
                  }
                }
              </script>
      			</div>
			   </li>
			 </ul>
	    </div>
  		<div class="col-lg-7">
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
                <form class="post_form" action="" method="POST" enctype="multipart/form-data">
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
  		<div class="col-lg-5">
  			<ul id="sortable8" class="connectedSortable">
			    <li>
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
			    </li>
			  </ul>
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

              <!-- < ?php
                $shared_docs_obj = new Document($con, $userLoggedIn);
                $shared_docs = $shared_docs_obj->getSharedDocuments($userLoggedIn);
                echo $shared_docs;
              ?> -->
            <div class=" contact-service">
              <a href="documents.php" class="main-button">View All</a>
            </div>
			    </li>
			  </ul>
  		</div>
  	</div>
</div>


      <script>
        var currentMonth = document.querySelector(".current-month");
        var calendarDays = document.querySelector(".calendar-days");
        var today = new Date();
        var date = new Date();


        currentMonth.textContent = date.toLocaleDateString("en-US", {month:'long', year:'numeric'});
        today.setHours(0,0,0,0);
        renderCalendar();

        function renderCalendar(){
            const prevLastDay = new Date(date.getFullYear(),date.getMonth(),0).getDate();
            const totalMonthDay = new Date(date.getFullYear(),date.getMonth()+1,0).getDate();
            const startWeekDay = new Date(date.getFullYear(),date.getMonth(),1).getDay();
           
            calendarDays.innerHTML = "";

            let totalCalendarDay = 6 * 7;
            for (let i = 0; i < totalCalendarDay; i++) {
                let day = i-startWeekDay;

                if(i <= startWeekDay){
                    // adding previous month days
                    calendarDays.innerHTML += `<div class='padding-day'>${prevLastDay-i}</div>`;
                }else if(i <= startWeekDay+totalMonthDay){
                    // adding this month days
                    date.setDate(day);
                    date.setHours(0,0,0,0);
                   
                    let dayClass = date.getTime()===today.getTime() ? 'current-day' : 'month-day';
                    calendarDays.innerHTML += `<div class='${dayClass}'>${day}</div>`;
                }else{
                    // adding next month days
                    calendarDays.innerHTML += `<div class='padding-day'>${day-totalMonthDay}</div>`;
                }
            }
        }

        document.querySelectorAll(".month-btn").forEach(function (element) {
          element.addEventListener("click", function () {
            date = new Date(currentMonth.textContent);
                date.setMonth(date.getMonth() + (element.classList.contains("prev") ? -1 : 1));
            currentMonth.textContent = date.toLocaleDateString("en-US", {month:'long', year:'numeric'});
            renderCalendar();
          });
        });

        document.querySelectorAll(".btn-cal").forEach(function (element) {
          element.addEventListener("click", function () {
                let btnClass = element.classList;
                date = new Date(currentMonth.textContent);
                if(btnClass.contains("today"))
                    date = new Date();
                else if(btnClass.contains("prev-year"))
                    date = new Date(date.getFullYear()-1, 0, 1);
                else
                    date = new Date(date.getFullYear()+1, 0, 1);
               
            currentMonth.textContent = date.toLocaleDateString("en-US", {month:'long', year:'numeric'});
            renderCalendar();
          });
        });
      </script>
