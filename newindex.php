<?php  

include("includes/header.php");

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
 background: white;
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
    <div class="col-lg-8">
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
                <h2>My Team</h2>
                <div class="my-teams-align">
                  <div class="images-my-teams">
                    <img src="https://images.unsplash.com/photo-1542178243-bc20204b769f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1480&q=80" width="40" height="40">
                    <img src="https://images.unsplash.com/photo-1631680900243-3c207cf5a481?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1480&q=80" width="40" height="40">
                    <img src="https://images.unsplash.com/photo-1578635073855-a89b3dd5cc18?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1480&q=80" width="40" height="40">
                    <img src="https://images.unsplash.com/photo-1627393100177-b4297e79a5be?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1480&q=80" width="40" height="40">
                  </div>
                  <p>15 Members</p>
                </div>
              </div>
            </li>
            
          </ul>
        </div>
        <div class="col-lg-6 col-md-6">
          <ul id="sortable3" class="connectedSortable">
            <li class="my-team">
              <div class="notifications-content-1">
                <h2>My Clients</h2>
                <div class="my-teams-align">
                  <div class="images-my-teams">
                    <img src="https://images.unsplash.com/photo-1542178243-bc20204b769f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1480&q=80" width="40" height="40">
                    <img src="https://images.unsplash.com/photo-1631680900243-3c207cf5a481?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1480&q=80" width="40" height="40">
                    <img src="https://images.unsplash.com/photo-1578635073855-a89b3dd5cc18?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1480&q=80" width="40" height="40">
                    <img src="https://images.unsplash.com/photo-1627393100177-b4297e79a5be?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1480&q=80" width="40" height="40">
                  </div>
                  <p>15 Clients</p>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <ul id="sortable4" class="connectedSortable">
        <li class="ui-state-default">
          
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

<div class="col-lg-4">
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
      <div class="container">
        <h3>Appointments</h3>
      </div>
      <br>

       <?php  

          // LIMIT THE NUMBER OF APPOINTMENTS LISTED
            $limit = 6;

            $apiKey = "74b89e453cede8378926d4bb785ef72602da0d19";
            $ssoToken = "5b09729a56bfa95b7a0be164e7f1d159f75d3b77ea3cd12dafc3036d70422627";
            $user_email = "ssk@health-connect.com";
            $start_date = date("d-m-Y");

            $start_date = explode("-", $start_date);
            $day1_day = $start_date[0];
            $day1_month = $start_date[1];
            $day1_year = $start_date[2];

          //$start_date = mktime(0, 0, 0, $day1_month, $day1_day, $day1_year);

            $day1_agendize_date = $day1_year."-".$day1_month."-".$day1_day;
            $start_date = $day1_agendize_date."T00:00:01";        

          // GET ALL ACCOUNTS FROM AGENDIZE
            $data = file_get_contents("https://sante.agendize.com/api/2.0/resellers/accounts?apiKey=$apiKey&token=$ssoToken&search=$user_email");
            $accounts = json_decode($data);

            foreach ($accounts->items as $account)
            {
            // WP EMAIL MATCHES AGENDIZE - GET COMPANY ID FOR NEXT API CALL
              $company_id = $account->id;
              $company_sso = $account->ssoToken;
            }

            if (isset($company_id))
            {
            // USER HAS AGENDIZE ACCOUNT - DISPLAY UPCOMING APPOINTMENTS
              ?>
              <div class="right_side_column_box">
                <!-- <h3>Upcoming Appointments</h3> -->
                <?php

            // GET BOOKING BUTTON FROM AGENDIZE
                $data1 = file_get_contents("https://sante.agendize.com/api/2.1/scheduling/buttons/?apiKey=$apiKey&token=$company_sso");
                $booking_buttons = json_decode($data1);

                foreach ($booking_buttons->items as $booking_button)
                {
                  $button_company_id = $booking_button->companyId;
                  $button_id = $booking_button->id;
                }

            // CREATE RANDOM NUMBER FOR VIDEO URL TO BE STORED IN AGENDIZE
                $bytes = random_bytes(32);
                $new_video_room = bin2hex($bytes);

            // BOOKING BUTTON
                ?>
            <!-- <div class="button-align-index">
            <a class="button-one" id="scheduling-< ?php echo $button_company_id; ?>" onclick="openScheduling(< ?php echo $button_company_id; ?>, {video: '< ?php echo $new_video_room; ?>'})" style="cursor : pointer; border: 0">Book Appointment</a></div> <script type="text/javascript">var scheduling = {server: 'client.health-connect.com', button: '< ?php echo $button_id; ?>', lang: 'en'};</script> <script type="text/javascript" src="https://client.health-connect.com/web/scheduling.js"></script>
            <br /> -->
            <?php

            // GET APPOINTMENT DATA
            $data2 = file_get_contents("https://sante.agendize.com/api/2.1/scheduling/companies/$button_company_id/appointments/?apiKey=$apiKey&token=$company_sso&startDate=$start_date&levelDetail=full");
            $appointments = json_decode($data2);

            $i = 0;

            foreach ($appointments->items as $appointment)
            {
              if ($i < $limit) {
                $appointment_date = niceDateTime($appointment->start->dateTime)[0];
                $appointment_time = niceDateTime($appointment->start->dateTime)[1];
                $appointment_end_time = niceDateTime($appointment->end->dateTime)[1];
                
                $duration = strtotime($appointment_end_time) - strtotime($appointment_time);
                $duration = $duration/60;

                $appointment_id = $appointment->id;
                
                $client_firstname = $appointment->client->firstName;
                $client_lastname = $appointment->client->lastName;
                $client_name = $client_firstname." ".$client_lastname;
                $client_email = $appointment->client->email;
                $staff_firstname = $appointment->staff->firstName;
                $staff_lastname = $appointment->staff->lastName;
                
                $appointment_time = substr($appointment_time, 0, -3);
                
                $video_room_id = $appointment->form[0]->value;
                $video_room_url = "https://consultation.health-connect.com/app/vid/room/?r=".$video_room_id."&u=".$staff_firstname."%20".$staff_lastname."&p=".$client_firstname."%20".$client_lastname."&d=".$staff_firstname."%20".$staff_lastname."&s=".$appointment_time."&du=".$duration."&role=1";

                echo "<div class='container'><div class='agendize-wrapper'><div class='calendar-icon'><i class='fas fa-calendar-alt'></i></div><div class='client-name'><h3> " . $client_firstname . " " . $client_lastname . "</h3><p><i class='far fa-clock'></i> " . $appointment_date . " " . $appointment_time . "</p> <a href='" . $video_room_url ."' target='_blank'><i class='fas fa-video'></i> Video</a></div></div></div>";
              }
              $i++;
            }

            echo "        </div>";

/*          if ($i == 0) {
            echo "<p>No appointments, loser.</p>";
            $appointment_div_height = "200px";
          }
          else*/
            $appointment_div_height = "810px";

        }        


        ?>
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


          </style>
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