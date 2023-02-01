<?php 

include("includes/header.php");
require 'includes/form_handlers/add_project_docs.php';

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


$project = new Project($con, $userLoggedIn);

if(isset($_POST['post'])) {

	$project_id = $_GET['id'];

	$uploadOk = 1;
	$imageName = $_FILES['fileToUpload']['name'];
	$errorMessage = "";

	if($imageName != "") {
		$targetDir = "assets/images/projects/";
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
		$poject = new Post($con, $userLoggedIn);
		$project->submitPost($_POST['post_text'], $project_id);
	}
	else {
		echo "<div style='text-align:center;' class='alert alert-danger'>
				$errorMessage
			</div>";
	}
}

if(isset($_GET['id'])) {

	if (isset($_GET['del'])) {
		$doc_id = $_GET['del'];
		$project_id = $_GET['id'];
		$query = mysqli_query($con, "DELETE FROM project_docs WHERE id='$doc_id'");
		header("Location:projects.php?id=$project_id&d=1");		
	}

	$project_id = $_GET['id'];

	$project_name = $project->getProjectName($project_id);
	$date_created = $project->getProjectCreatedDate($project_id);
	$date_created = date("d/m/Y", strtotime($date_created));
	$created_by = $project->createdBy($project_id);


?>





				<?php // echo "Posts: " . $user['num_posts'] . "<br />"; 
				// echo "Likes: " . $user['num_likes']; ?>

				<?php 
							}
							else {

								if(isset($_POST['join_project'])) {

									$project_id = $_POST['id'];
									$add_member_query = mysqli_query($con, "UPDATE projects SET member_array=CONCAT(member_array, '$userLoggedIn,') WHERE id='$project_id'");
									header("Location: projects.php?id=$project_id");
								}

								$project_list = $project->mainProjectList();

						?>


				<div class="container my-news-feed-title">
				    <h1><?php echo $user['first_name'] . " " . $user['last_name']; ?> News Feed</h1>
				</div>


				<div class="container">
					<div class="row">
						<div class="col-lg-8">
							<div class="my-news-feed">
								<div class="main_column column main_column_recent_activity">
									<div class="banner-news-feed">
										<h2>News Feed</h2>
									</div>

									<div class="recent-feed-activity">
										<form class="post_form" action="index.php" method="POST" enctype="multipart/form-data">
											<textarea name="post_text" id="input22" class="textarea-field-profile" placeholder="Got something to say?"></textarea>
											<div id="users22" class="users">
												<ul class="list22"></ul>
											</div>
											<div class="file-align-index">
												<div class='file-input'>
							              			<input type="file" name="fileToUpload" id="fileToUpload" />
							                			<span class='button'>Choose</span>
							                  				<span class='label' data-js-label>No file selected</label>
							            		</div>
												<br>
												<button type="submit" name="post" class="main-button">Post</button>
											</div>
										</form>

										<div class="posts_area"></div>
										<div style="text-align: center;"><img src="assets/images/icons/loading.gif" id="loading" /></div>
									</div>
								</div>
							</div>
							<br style="clear: both;" />
						</div>
						

						
						<div class="col-lg-4">
							<div class="my-groups-widget">
								<div class="banner-news-feed">
									<h2>My Groups</h2>
								</div>
								<div class="my-groups-scrolling">
									<div class="row">
										<?php echo $project_list; ?>
									</div>
								</div>
								
								<div class="main-button-position">
									<a href="projects.php" class="main-button">View all</a>
								</div>

								<script>
								$(document).ready(function(){
									 $(".my-groups-widget").find(".col-3").addClass("col-6");
								    $(".my-groups-widget").find(".col-3").removeClass("col-3");
								  
								});
								</script>	
							</div>
						</div>	
							<?php 
								}
							?>
					</div>
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


<?php  

include("includes/footer.php");

?>