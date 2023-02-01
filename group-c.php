<?php  

include("includes/header-group-c.php");

?>




<style>
    
    #sortable22, #sortable23, #sortable24, #sortable25, #sortable26 {
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
    #sortable22 li, #sortable23 li, #sortable24 li, #sortable25 li, #sortable26 li  {
     /* border: 1px solid black;*/
      /*padding: 5px;*/
      font-size: 1.2em;
      width: 100%;
      border-radius: 16px;
      background: white;
      box-shadow: 0px 0px 11px 2px #e5e9e6;
    }

  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

  <script>
  $( function() {
    $( "#sortable22, #sortable23, #sortable24, #sortable25, #sortable26" ).sortable({
      connectWith: ".connectedSortable"
    }).disableSelection();
  } );
  </script>
<br>
<br>
<div class="container">
	<div class="row">
		<div class="col-lg-7">
			<ul id="sortable22" class="connectedSortable">
				 <li class="banner-page">
          <div class="welcome-back">
            <h2>Welcome back,</h2> <a href="<?php echo $userLoggedIn; ?>"><?php echo $user['first_name'] . " " . $user['last_name']; ?></a>
          </div>
          <div class="nice-day-work">
            <p>Service Name and Ward</p>
          </div>
        </li>
			</ul>

			<ul id="sortable23" class="connectedSortable">
				<li>
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
				</li>
			</ul>

		
		</div>
		<div class="col-lg-5">
			<ul id="sortable24" class="connectedSortable">
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
			<ul id="sortable25" class="connectedSortable">
				<li>
					<div class="banner-news-feed">
    				<h2>My Service Users</h2>
  			 	</div>
          <div class="wrapper-service-users">
          <div class="service-users">
            <img src="https://images.unsplash.com/photo-1614644147724-2d4785d69962?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1364&q=80">
            <h3>Sarah Marsh</h3>
            <div class="contact-icons">
              <a href="#"><i class="fas fa-comment-dots"></i></a>
              <a href="#"><i class="fas fa-envelope"></i></a>
              <a href="#"><i class="fas fa-phone"></i></a>
            </div>
          </div>
          <div class="service-users">
            <img src="https://images.unsplash.com/photo-1614644147724-2d4785d69962?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1364&q=80">
            <h3>Sarah Marsh</h3>
            <div class="contact-icons">
              <a href="#"><i class="fas fa-comment-dots"></i></a>
              <a href="#"><i class="fas fa-envelope"></i></a>
              <a href="#"><i class="fas fa-phone"></i></a>
            </div>
          </div>
          <div class="service-users">
            <img src="https://images.unsplash.com/photo-1614644147724-2d4785d69962?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1364&q=80">
            <h3>Sarah Marsh</h3>
            <div class="contact-icons">
              <a href="#"><i class="fas fa-comment-dots"></i></a>
              <a href="#"><i class="fas fa-envelope"></i></a>
              <a href="#"><i class="fas fa-phone"></i></a>
            </div>
          </div>
          <div class="service-users">
            <img src="https://images.unsplash.com/photo-1614644147724-2d4785d69962?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1364&q=80">
            <h3>Sarah Marsh</h3>
            <div class="contact-icons">
              <a href="#"><i class="fas fa-comment-dots"></i></a>
              <a href="#"><i class="fas fa-envelope"></i></a>
              <a href="#"><i class="fas fa-phone"></i></a>
            </div>
          </div>
          <div class="service-users">
            <img src="https://images.unsplash.com/photo-1614644147724-2d4785d69962?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1364&q=80">
            <h3>Sarah Marsh</h3>
            <div class="contact-icons">
              <a href="#"><i class="fas fa-comment-dots"></i></a>
              <a href="#"><i class="fas fa-envelope"></i></a>
              <a href="#"><i class="fas fa-phone"></i></a>
            </div>
          </div>
          <div class="service-users">
            <img src="https://images.unsplash.com/photo-1614644147724-2d4785d69962?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1364&q=80">
            <h3>Sarah Marsh</h3>
            <div class="contact-icons">
              <a href="#"><i class="fas fa-comment-dots"></i></a>
              <a href="#"><i class="fas fa-envelope"></i></a>
              <a href="#"><i class="fas fa-phone"></i></a>
            </div>
          </div>
          <div class="service-users">
            <img src="https://images.unsplash.com/photo-1614644147724-2d4785d69962?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1364&q=80">
            <h3>Sarah Marsh</h3>
            <div class="contact-icons">
              <a href="#"><i class="fas fa-comment-dots"></i></a>
              <a href="#"><i class="fas fa-envelope"></i></a>
              <a href="#"><i class="fas fa-phone"></i></a>
            </div>
          </div>
          <div class="service-users">
            <img src="https://images.unsplash.com/photo-1614644147724-2d4785d69962?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1364&q=80">
            <h3>Sarah Marsh</h3>
            <div class="contact-icons">
              <a href="#"><i class="fas fa-comment-dots"></i></a>
              <a href="#"><i class="fas fa-envelope"></i></a>
              <a href="#"><i class="fas fa-phone"></i></a>
            </div>
          </div>
          <div class="service-users">
            <img src="https://images.unsplash.com/photo-1614644147724-2d4785d69962?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1364&q=80">
            <h3>Sarah Marsh</h3>
            <div class="contact-icons">
              <a href="#"><i class="fas fa-comment-dots"></i></a>
              <a href="#"><i class="fas fa-envelope"></i></a>
              <a href="#"><i class="fas fa-phone"></i></a>
            </div>
          </div>
          </div>

          <div class=" contact-service" >
            <a href="#" class="main-button">View All</a>
          </div>
				</li>
			</ul>
			<ul id="sortable26" class="connectedSortable">
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
              <a href="#" class="main-button">View All</a>
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
<?php 

include("includes/footer.php");

?>