<?php  

include("includes/header.php");

if(isset($_POST['new_project'])) {

	$project_name = mysqli_real_escape_string($con, $_POST['project_name']);
	$project_description = mysqli_real_escape_string($con, $_POST['project_description']);
	$project_type = $_POST['project_type'];

	$project = new Project($con, $userLoggedIn);
	$project->createProject($project_name, $project_description, $project_type);
}

if(!isset($_POST['step'])) {

?>
	<div class="container">
		<div class="project-header my-news-feed-title">
			<h1>New Project</h1>
		</div>
		<div class="project-body">
			<form method="POST" action="new_project.php" class="project-form">
				<div class="row">
					<div class="col-12">
						<input type="text" name="project_name" placeholder="Project Name" class="input-project-new" />
					</div>		
				</div>
				<br>
				<div class="row">
					<div class="col-12">
						<textarea placeholder="Project Description" class="input-project-new-textarea" name="project_description"></textarea>
					</div>
				</div>
				<input type="hidden" name="step" value="1" />
				<br>
				<a id="myBtn" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Choose Image</a>
				<div class="container" style="margin-top: 20px;">
  					<span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
  					<img id="expandedImg" style="width:100%">
  					<div id="imgtext"></div>
				</div>

				<!------ Modal ----->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="row">
								<div class="column"> 
									<img src="assets/images/banners/equilibrium-patient.png" alt="banner1" style="width:100%" onclick="myFunction(this);">
								</div>
								<div class="column"> 
									<img src="assets/images/banners/equilibrium1.png" alt="banner2" style="width:100%" onclick="myFunction(this);"> 
								</div>
								<div class="column"> 
									<img src="assets/images/banners/pro-banner.png" alt="banner3" style="width:100%" onclick="myFunction(this);"> 
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>

				<br>
				<button type="submit" class="main-button">Continue</button>
			</form>
		</div>
		
	</div>

<?php

}

if($_POST['step'] == 1) {

	$project_name = $_POST['project_name'];
	$project_description = $_POST['project_description'];

?>
		<div class="container project-header my-news-feed-title">
			<h1>New Project</h1>
			<br />
		</div>
		<div class="container">
		<div class="new-project-wrapper">
			<div class="banner-news-feed">
				<h2>Privacy</h2>
			</div>
	
			<form method="POST" action="new_project.php" class="project-form-new">
				<div class="row">
					<div class="col-4">
						<input type="radio" name="project_type" value="public_project" class="check-box-button" id="public_group" />						
						<label for="public_group">Public Project:</label>
						<ul>
							<li>Anybody can join this project.</li>
							<li>This project will be listed in the projects directory and in search results.</li>
							<li>Project content and activity will be visible to all site members.</li>
						</ul>
					</div>
					<div class="col-4">
						<input type="radio" name="project_type" value="private_project" class="check-box-button" id="private_group"/>						
						<label for="private_group">Private Project:</label>
						<ul>
							<li>Only people who request membership and are accepted can join the project.</li>
							<li>This project will be listed in the project directory and in search results.</li>
							<li>Project content and activity will only be visible to members of the project.</li>
						</ul>
					</div>		
					<div class="col-4">
						<input type="radio" name="project_type" value="hidden_project" class="check-box-button" id="hidden_project"/>						
						<label for="hidden_project">Hidden Project:</label>
						<ul>
							<li>Only people who are invited can join the project.</li>
							<li>This project will not be listed in the project directory or search results.</li>
							<li>Project content and activity will only be visible to members of the project.</li>
						</ul>
					</div>														
				</div>
				<input type="hidden" name="step" value="3" />
				<input type="hidden" name="project_name" value="<?php echo $project_name; ?>" />
				<input type="hidden" name="project_description" value="<?php echo $project_description; ?>" />
				<button type="submit" class="main-button" name="new_project">Create Project</button>
			</form>
		</div>
	</div>

<?php

}


?>
</div>
</body>
</html>

<style>

	/* Expanding image text */
	#imgtext {
	  position: absolute;
	  bottom: 15px;
	  left: 15px;
	  color: white;
	  font-size: 20px;
	}

	/* Closable button inside the expanded image */
	.closebtn {
	  position: absolute;
	  top: 10px;
	  right: 15px;
	  color: white;
	  font-size: 35px;
	  cursor: pointer;
	}
	form.project-form #myBtn {
	    background: linear-gradient(129deg, rgba(73,190,255,1) 0%, rgba(128,72,255,1) 100%) ;
	    border: none;
	    color: white;
	    text-decoration: none;
	    padding: 10.5px 40px;
	    /* height: 56px; */
	    border-radius: 30px;
	    font-size: 16px;
	}
</style>
<script>
	$(document).ready(function () {
	    $("#myBtn").click(function(){
	         $('#myModal').modal('show');
	    });
	});

	function myFunction(imgs) {
	  	var expandImg = document.getElementById("expandedImg");
	  	var imgText = document.getElementById("imgtext");
	  	expandImg.src = imgs.src;
	  	imgText.innerHTML = imgs.alt;
	  	expandImg.parentElement.style.display = "block";
	}
	$("#saveChange").on("click", function (e) {
        e.preventDefault();
        $("#myModal").modal("hide");
        $('#myModal').data("modal", null);
    }); 
</script>