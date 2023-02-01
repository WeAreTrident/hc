	<?php  

	include("includes/header.php");

	?>

	<style>

	#sortable10, #sortable11, #sortable12, #sortable13, #sortable14 {
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
	#sortable10 li, #sortable11 li, #sortable12 li, #sortable13 li, #sortable14 li  {
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
			$( "#sortable10, #sortable11, #sortable12, #sortable13, #sortable14" ).sortable({
				connectWith: ".connectedSortable"
			}).disableSelection();
		} );
	</script>
	<br>
	<br>
	<div class="container">
		<div class="row">
			<div class="col-lg-7">
				<ul id="sortable10" class="connectedSortable">
					<li class="banner-page">
						<div class="welcome-back">
							<h2>Welcome back,</h2> <a href="<?php echo $userLoggedIn; ?>"><?php echo $user['first_name'] . " " . $user['last_name']; ?></a>
						</div>
						<div class="nice-day-work">
							<p>Moston Grange</p>
						</div>
					</li>
				</ul>

				<ul id="sortable14" class="connectedSortable">
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
	<br>
	<button type="submit" name="post" class="main-button">Post</button>
	</div>
	</form>
	<div class="posts_area"></div>
	<div style="text-align: center;"><img src="assets/images/icons/loading.gif" id="loading" /></div>
	</div>
	</li>
	</ul>

				
			</div>
			<div class="col-lg-5">
				<ul id="sortable11" class="connectedSortable">
					<li>

						<div class="banner-news-feed">
							<h2>Reporting</h2>
						</div>
						<div class="reporting-gird">
							<div class="reporting-card">
								<h3>Incident Reports</h3>
								<p class="reporting-card-date">Date 12/03/2022</p>
								<hr>
								<p class="reporting-card-name">From Robert Smith</p>
								<a href="#">View File</a>
							</div>
							<div class="reporting-card">
								<h3>Compliments</h3>
								<p class="reporting-card-date">Date 13/03/2022</p>
								<hr>
								<p class="reporting-card-name">From Robert Smith</p>
								<a href="#">View File</a>
							</div>
							<div class="reporting-card">
								<h3>KLOES</h3>
								<p class="reporting-card-date">Date 14/03/2022</p>
								<hr>
								<p class="reporting-card-name">From Robert Smith</p>
								<a href="#">View File</a>
							</div>
							<div class="reporting-card">
								<h3>Staff Training</h3>
								<p class="reporting-card-date">Date 15/03/2022</p>
								<hr>
								<p class="reporting-card-name">From Robert Smith</p>
								<a href="#">View File</a>
							</div>
							<div class="reporting-card">
								<h3>Report Name</h3>
								<p class="reporting-card-date">Date 15/02/2021</p>
								<hr>
								<p class="reporting-card-name">From Robert Smith</p>
								<a href="#">View File</a>
							</div>
							<div class="reporting-card">
								<h3>Report Name</h3>
								<p class="reporting-card-date">Date 15/02/2021</p>
								<hr>
								<p class="reporting-card-name">From Robert Smith</p>
								<a href="#">View File</a>
							</div>
							<div class="reporting-card">
								<h3>Report Name</h3>
								<p class="reporting-card-date">Date 15/02/2021</p>
								<hr>
								<p class="reporting-card-name">From Robert Smith</p>
								<a href="#">View File</a>
							</div>
							<div class="reporting-card">
								<h3>Report Name</h3>
								<p class="reporting-card-date">Date 15/02/2021</p>
								<hr>
								<p class="reporting-card-name">From Robert Smith</p>
								<a href="#">View File</a>
							</div>
						</div>
						<div class=" contact-service" >
	              <a href="#" class="main-button">View All</a>
	            </div>
					</li>
				</ul>

				<ul id="sortable12" class="connectedSortable">
					<li>
						<div class="banner-news-feed">
							<h2>Latest Audit Submissions</h2>
						</div>
						<div class="reporting-gird">
							<div class="reporting-card">
								<h3>Safe</h3>
								<p class="reporting-card-date">Date 12/03/2022</p>
								<p class="reporting-card-name">From Robert Smith</p>
								<a href="#">View File</a>
							</div>
							<div class="reporting-card">
								<h3>Effective</h3>
								<p class="reporting-card-date">Date 13/03/2022</p>
								<p class="reporting-card-name">From Robert Smith</p>
								<a href="#">View File</a>
							</div>
							<div class="reporting-card">
								<h3>Caring</h3>
								<p class="reporting-card-date">Date 13/03/2022</p>
								<p class="reporting-card-name">From Robert Smith</p>
								<a href="#">View File</a>
							</div>
							<div class="reporting-card">
								<h3>Responsive</h3>
								<p class="reporting-card-date">Date 15/03/2022</p>
								<p class="reporting-card-name">From Robert Smith</p>
								<a href="#">View File</a>
							</div>
							<div class="reporting-card">
								<h3>Document Name</h3>
								<p class="reporting-card-date">Date 15/02/2021</p>
								<p class="reporting-card-name">From Robert Smith</p>
								<a href="#">View File</a>
							</div>
							<div class="reporting-card">
								<h3>Document Name</h3>
								<p class="reporting-card-date">Date 15/02/2021</p>
								<p class="reporting-card-name">From Robert Smith</p>
								<a href="#">View File</a>
							</div>
							<div class="reporting-card">
								<h3>Document Name</h3>
								<p class="reporting-card-date">Date 15/02/2021</p>
								<p class="reporting-card-name">From Robert Smith</p>
								<a href="#">View File</a>
							</div>
							<div class="reporting-card">
								<h3>Document Name</h3>
								<p class="reporting-card-date">Date 15/02/2021</p>
								<p class="reporting-card-name">From Robert Smith</p>
								<a href="#">View File</a>
							</div>
						</div>
						<div class=" contact-service" >
	              <a href="#" class="main-button">View All</a>
	            </div>
					</li>
				</ul>

				<ul id="sortable13" class="connectedSortable">
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
								<div class="indicator-wrapper" style="margin-top: 30px;">
									<div class="indicator-one" style="margin-top: 10px;"></div>
									<p>Negative</p>
								</div>
								<div class="indicator-wrapper">
									<div class="indicator-two" style="margin-top: 10px;"></div>
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
				
	</div>
	</div>
	</div>




	<?php 

	include("includes/footer.php");

	?>