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

#sortable15, #sortable16, #sortable17, #sortable18, #sortable19, #sortable20, #sortable21 {
	border: 1px solid #eee;
	width: 100%;
	min-height: 60px;
	list-style-type: none;
	/*margin: 0;*/
	padding: 0px;
	/* float: left;*/
	margin-right: 10px;
	border-radius: 8px;
}
#sortable15 li, #sortable16 li, #sortable17 li, #sortable18 li, #sortable19 li, #sortable20 li, #sortable21 li  {
	/* border: 1px solid black;*/
	/*padding: 5px;*/
	font-size: 1.2em;
	width: 100%;
	border-radius: 8px;
	background: white;
	box-shadow: 0px 0px 11px 2px #e5e9e6;
}

</style>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

<script>
	$( function() {
		$( "#sortable15, #sortable16, #sortable17, #sortable18, #sortable19, #sortable20, #sortable21" ).sortable({
			connectWith: ".connectedSortable"
		}).disableSelection();
	} );
</script>
<br>
<br>
<div class="container">
	<div class="row">
		<div class="col-lg-7">
			<ul id="sortable15" class="connectedSortable">
				<li class="banner-page">
					<div class="welcome-back">
						<h2>Welcome back,</h2> <a href="<?php echo $userLoggedIn; ?>"><?php echo $user['first_name'] . " " . $user['last_name']; ?></a>
					</div>
					<div class="nice-day-work">
						<p><?php echo $provider_name; ?></p>
					</div>
				</li>
			</ul>
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
                    <a href="#" class="first">+ Document</a>
                    <a href="#">+ Video</a>
                    <a href="#">+ Image</a>
                    <a href="#">+ Article</a>
                    <a type="submit" name="post" class="feed-button">Post</a>                
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
<!-- 			<ul id="sortable16" class="connectedSortable">
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
			</ul> -->

			<ul id="sortable17" class="connectedSortable">
				<li>
					<div class="banner-news-feed">
						<h2>Reporting</h2>
					</div>
					<div class="reporting-gird reporting-gird-group-b">
							<div class="report-box">
								<div class="reporting-card">
									<h3>Document Name</h3>
									<p class="reporting-card-date">Date 15/02/2021</p>
									<hr>
                  <div class="row">
                    <div class="col-4">
                      <img src="assets/images/profile_pics/Richa.png" alt="" class="img-fluid">
                    </div>
                    <div class="col-8">
                      <p class="reporting-card-name">From Robert Smith <br><span>Date 15/02/2021</span></p>
                    </div>
                  </div>
								</div>
								<a href="#">View File</a>
							</div>
							<div class="report-box">
								<div class="reporting-card">
									<h3>Document Name</h3>
									<p class="reporting-card-date">Date 15/02/2021</p>
									<hr>
									<div class="row">
                    <div class="col-4">
                      <img src="assets/images/profile_pics/Richa.png" alt="" class="img-fluid">
                    </div>
                    <div class="col-8">
                      <p class="reporting-card-name">From Robert Smith <br><span>Date 15/02/2021</span></p>
                    </div>
                  </div>
								</div>
								<a href="#">View File</a>
							</div>
							<div class="report-box">
								<div class="reporting-card">
									<h3>Document Name</h3>
									<p class="reporting-card-date">Date 15/02/2021</p>
									<hr>
									<div class="row">
                    <div class="col-4">
                      <img src="assets/images/profile_pics/Richa.png" alt="" class="img-fluid">
                    </div>
                    <div class="col-8">
                      <p class="reporting-card-name">From Robert Smith <br><span>Date 15/02/2021</span></p>
                    </div>
                  </div>
								</div>
								<a href="#">View File</a>
							</div>
							<div class="report-box">
								<div class="reporting-card">
									<h3>Document Name</h3>
									<p class="reporting-card-date">Date 15/02/2021</p>
									<hr>
									<div class="row">
                    <div class="col-4">
                      <img src="assets/images/profile_pics/Richa.png" alt="" class="img-fluid">
                    </div>
                    <div class="col-8">
                      <p class="reporting-card-name">From Robert Smith <br><span>Date 15/02/2021</span></p>
                    </div>
                  </div>
								</div>
								<a href="#">View File</a>
							</div>
							<div class="report-box">
								<div class="reporting-card">
									<h3>Document Name</h3>
									<p class="reporting-card-date">Date 15/02/2021</p>
									<hr>
									<div class="row">
                    <div class="col-4">
                      <img src="assets/images/profile_pics/Richa.png" alt="" class="img-fluid">
                    </div>
                    <div class="col-8">
                      <p class="reporting-card-name">From Robert Smith <br><span>Date 15/02/2021</span></p>
                    </div>
                  </div>
								</div>
								<a href="#">View File</a>
							</div>
							<div class="report-box">
								<div class="reporting-card">
									<h3>Document Name</h3>
									<p class="reporting-card-date">Date 15/02/2021</p>
									<hr>
									<div class="row">
                    <div class="col-4">
                      <img src="assets/images/profile_pics/Richa.png" alt="" class="img-fluid">
                    </div>
                    <div class="col-8">
                      <p class="reporting-card-name">From Robert Smith <br><span>Date 15/02/2021</span></p>
                    </div>
                  </div>
								</div>
								<a href="#">View File</a>
							</div>
							<div class="report-box">
								<div class="reporting-card">
									<h3>Document Name</h3>
									<p class="reporting-card-date">Date 15/02/2021</p>
									<hr>
									<div class="row">
                    <div class="col-4">
                      <img src="assets/images/profile_pics/Richa.png" alt="" class="img-fluid">
                    </div>
                    <div class="col-8">
                      <p class="reporting-card-name">From Robert Smith <br><span>Date 15/02/2021</span></p>
                    </div>
                  </div>
								</div>
								<a href="#">View File</a>
							</div>
							<div class="report-box">
								<div class="reporting-card">
									<h3>Document Name</h3>
									<p class="reporting-card-date">Date 15/02/2021</p>
									<hr>
									<div class="row">
                    <div class="col-4">
                      <img src="assets/images/profile_pics/Richa.png" alt="" class="img-fluid">
                    </div>
                    <div class="col-8">
                      <p class="reporting-card-name">From Robert Smith <br><span>Date 15/02/2021</span></p>
                    </div>
                  </div>
								</div>
								<a href="#">View File</a>
							</div>
					</div>
					<div class=" contact-service" >
            <a href="#" class="main-button">View All</a>
          </div>
				</li>
			</ul>


		</div>
		<div class="col-lg-5">
			<ul id="sortable18" class="connectedSortable">
				<li>
					<div class="banner-news-feed">
						<h2>Latest Audit Submissions</h2>
					</div>
						<div class="reporting-gird">
							<div class="report-box">
								<div class="reporting-card">
									<h3>Document Name</h3>
									<p class="reporting-card-date">Date 15/02/2021</p>
									<hr>
									<div class="row">
                    <div class="col-4">
                      <img src="assets/images/profile_pics/Richa.png" alt="" class="img-fluid">
                    </div>
                    <div class="col-8">
                      <p class="reporting-card-name">From Robert Smith <br><span>Date 15/02/2021</span></p>
                    </div>
                  </div>
								</div>
								<a href="#">View File</a>
							</div>
							<div class="report-box">
								<div class="reporting-card">
									<h3>Document Name</h3>
									<p class="reporting-card-date">Date 15/02/2021</p>
									<hr>
									<div class="row">
                    <div class="col-4">
                      <img src="assets/images/profile_pics/Richa.png" alt="" class="img-fluid">
                    </div>
                    <div class="col-8">
                      <p class="reporting-card-name">From Robert Smith <br><span>Date 15/02/2021</span></p>
                    </div>
                  </div>
								</div>
								<a href="#">View File</a>
							</div>
							<div class="report-box">
								<div class="reporting-card">
									<h3>Document Name</h3>
									<p class="reporting-card-date">Date 15/02/2021</p>
									<hr>
									<div class="row">
                    <div class="col-4">
                      <img src="assets/images/profile_pics/Richa.png" alt="" class="img-fluid">
                    </div>
                    <div class="col-8">
                      <p class="reporting-card-name">From Robert Smith <br><span>Date 15/02/2021</span></p>
                    </div>
                  </div>
								</div>
								<a href="#">View File</a>
							</div>
							<div class="report-box">
								<div class="reporting-card">
									<h3>Document Name</h3>
									<p class="reporting-card-date">Date 15/02/2021</p>
									<hr>
									<div class="row">
                    <div class="col-4">
                      <img src="assets/images/profile_pics/Richa.png" alt="" class="img-fluid">
                    </div>
                    <div class="col-8">
                      <p class="reporting-card-name">From Robert Smith <br><span>Date 15/02/2021</span></p>
                    </div>
                  </div>
								</div>
								<a href="#">View File</a>
							</div>
							<div class="report-box">
								<div class="reporting-card">
									<h3>Document Name</h3>
									<p class="reporting-card-date">Date 15/02/2021</p>
									<hr>
									<div class="row">
                    <div class="col-4">
                      <img src="assets/images/profile_pics/Richa.png" alt="" class="img-fluid">
                    </div>
                    <div class="col-8">
                      <p class="reporting-card-name">From Robert Smith <br><span>Date 15/02/2021</span></p>
                    </div>
                  </div>
								</div>
								<a href="#">View File</a>
							</div>
							<div class="report-box">
								<div class="reporting-card">
									<h3>Document Name</h3>
									<p class="reporting-card-date">Date 15/02/2021</p>
									<hr>
									<div class="row">
                    <div class="col-4">
                      <img src="assets/images/profile_pics/Richa.png" alt="" class="img-fluid">
                    </div>
                    <div class="col-8">
                      <p class="reporting-card-name">From Robert Smith <br><span>Date 15/02/2021</span></p>
                    </div>
                  </div>
								</div>
								<a href="#">View File</a>
							</div>
							<div class="report-box">
								<div class="reporting-card">
									<h3>Document Name</h3>
									<p class="reporting-card-date">Date 15/02/2021</p>
									<hr>
									<img src="assets/images/profile_pics/Richa.png" alt="" class="img-fluid">
									<p class="reporting-card-name">From Robert Smith<span>Date 15/02/2021</span></p>
								</div>
								<a href="#">View File</a>
							</div>
						</div>
					<div class=" contact-service" >
              <a href="#" class="main-button">View All</a>
            </div>

				</li>
			</ul>
			<ul id="sortable19" class="connectedSortable">
				<li>
					<div class="banner-news-feed">
						<h2>Compliments and Complaints</h2>
					</div>
						<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
					<div class="row">
						<div class="col-lg-6">
							<div>
								<canvas id="myChart"></canvas>
							</div>
							<script>
							 const data = {
							  // labels: [
							  //   'Red',
							  //   'Blue'
							    
							  // ],
							  datasets: [{
							    label: 'My First Dataset',
							    data: [300, 50],
							    backgroundColor: [
							      'rgb(73,190,255)',
							      'rgb(128, 72, 255)'
							    ],
							    hoverOffset: 4
							  }]
							};

							const config = {
							  type: 'doughnut',
							  data: data,
							};
							</script>
							<script>
		  const myChart = new Chart(
		    document.getElementById('myChart'),
		    config
		  );
		</script>
							
						</div>
						<div class="col-lg-6">
							<div class="indicator-wrapper">
								<div class="indicator-one"></div>
								<p>Negative</p>
							</div>
							<div class="indicator-wrapper">
								<div class="indicator-one"></div>
								<p>Positive</p>
							</div>
							<div>
								<div></div>
								<div>
									<p>70% Positivity</p>
									<p>Today</p>
								</div>
							</div>
						</div>
					</div>
				</li>
			</ul>
			<ul id="sortable20" class="connectedSortable">
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
             <div class="contact-service" >
						<a href="#" class="main-button">View All</a>
					</div>
				</li>
			</ul>
			<ul id="sortable21" class="connectedSortable">
				<li>
					<div class="banner-news-feed">
						<h2>My Service Users</h2>
					</div>
					<div class="wrapper-service-users">

                        <?php

                        $q = mysqli_query($con, "SELECT username FROM service_users WHERE provider='$provider_name'");
                        while ($row = mysqli_fetch_array($q)) {

                            $service_user_obj = new User($con, $row['username']);
                            $service_user_name = $service_user_obj->getFirstAndLastName();

                            $service_user_pic = $service_user_obj->getProfilePic();

                        ?>
                        <div class="service-users">
                            <a href="https://hc.yourproject-test.co.uk/<?php echo $row['username']; ?>" style="text-decoration:none;"><img src="<?php echo $service_user_pic; ?>">
                            <h3><?php echo $service_user_name; ?></h3></a>
                            <div class="contact-icons">
                                <a href="#"><i class="fas fa-comment-dots"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                                <a href="#"><i class="fas fa-phone"></i></a>
                            </div>
                        </div>
                        <?php

                        }

                        ?>


					</div>

					<div class="contact-service" >
						<a href="#" class="main-button">View All</a>
					</div>
					
				</li>
			</ul>
		</div>
	</div>
</div>


<?php 

//include