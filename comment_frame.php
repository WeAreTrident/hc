<?php

require 'config/config.php';
include("includes/classes/User.php");
include("includes/classes/Post.php");
include("includes/classes/Notification.php");

if (isset($_SESSION['username'])) {
	$userLoggedIn = $_SESSION['username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
	$user = mysqli_fetch_array($user_details_query);
}
else {
	header("Location: register.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" type="text/css" href="assets/css/styles.css">
	<link rel="stylesheet" type="text/css" href="assets/css/profile.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/style-sign-up.css" />

</head>
<body style="background: transparent !important;">

<?php

// Get id of post
if (isset($_GET['post_id'])) {
	$post_id = $_GET['post_id'];
    //$post_id = $_POST['post_id'];
}

$user_query = mysqli_query($con, "SELECT added_by, user_to FROM posts WHERE id='$post_id'");
$row = mysqli_fetch_array($user_query);

$posted_to = $row['added_by'];
$user_to = $row['user_to'];

if (isset($_POST['postComment' . $post_id])) {
	$post_body = $_POST['post_body'];
	$post_body = mysqli_escape_string($con, $post_body);
	$date_time_now = date("Y-m-d H:i:s");
	$insert_post = mysqli_query($con, "INSERT INTO comments VALUES ('', '$post_body', '$userLoggedIn', '$posted_to', '$date_time_now', 'no', '$post_id')");
	
	if($posted_to != $userLoggedIn) {
		$notification = new Notification($con, $userLoggedIn);
		$notification->insertNotification($post_id, $posted_to, "comment");		
	}
	if($user_to != 'none' && $user_to != $userLoggedIn) {
		$notification = new Notification($con, $userLoggedIn);
		$notification->insertNotification($post_id, $user_to, "profile_comment");	
	}

	$get_commenters = mysqli_query($con, "SELECT * FROM comments WHERE post_id='$post_id'");
	$notified_users = array();
	while($row = mysqli_fetch_array($get_commenters)) {
		if($row['posted_by'] != $posted_to && $row['posted_by'] != $user_to && $row['posted_by'] != $userLoggedIn && !in_array($row['posted_by'], $notified_users)) {
			
			$notification = new Notification($con, $userLoggedIn);
			$notification->insertNotification($post_id, $row['posted_by'], "comment_non_owner");

			array_push($notified_users, $row['posted_by']);
		}
	}

	echo "<p>Comment posted!</p>";
}

?>
<div class="comment-field-profile">
	<form class="comment-form-post" action="comment_frame.php?post_id=<?php echo $post_id; ?>" id="comment_form" name="postComment<?php echo $post_id; ?>" method="POST">
		<textarea name="post_body" placeholder="Use @mentions to get someone's attention"></textarea>
		<div id="users23" class="users">
			<ul class="list23"></ul>
		</div>
		<div class="file-input">
			<input type="file" name="fileToUpload" id="fileToUpload">
			  <span class="button">Choose</span>
					<span class="label" data-js-label="">No file selected
		</span></div>
		<button class="main-button" type="submit" name="postComment<?php echo $post_id; ?>">Post</button>
	</form>
</div>

<script>
	function toggle() {
		var element = document.getElementById("comment_section");

		if (element.style.display == "block") {
			element.style.display = "none";
		}
		else {
			element.style.display = "block";
		}
	}
</script>
<!-- Load comments -->
<?php

$get_comments = mysqli_query($con, "SELECT * FROM comments WHERE post_id='$post_id' ORDER BY id ASC");
$count = mysqli_num_rows($get_comments);

if ($count != 0) {

	while ($comment = mysqli_fetch_array($get_comments)) {

		$comment_body = $comment['post_body'];
		$posted_to = $comment['posted_to'];
		$posted_by = $comment['posted_by'];
		$date_added = $comment['date_added'];
		$removed = $comment['removed'];

		// Timeframe
		$date_time_now = date("Y-m-d H:i:s");
		$start_date = new DateTime($date_added);
		$end_date = new DateTime($date_time_now);
		$interval = $start_date->diff($end_date); // Difference between dates

		if ($interval->y >= 1) {
			if ($interval == 1) {
				$time_message = $interval->y . " year ago";					
			}
			else {
				$time_message = $interval->y . " years ago";
			}

		}
		elseif ($interval->m >= 1) {
		 	if ($interval->d == 0) {
		 		$days = " ago";
		 	}
		 	elseif ($interval->d == 1) {
		 		$days = $interval->d . " day ago";
		 	}
		 	else {
		 		$days = $interval->d . " days ago";
		 	}

		 	if ($interval->m == 1) {
		 		$time_message = $interval->m . " month " . $days;
		 	}
		 	else {
		 		$time_message = $interval->m . " months " . $days;
		 	}
		} 
		elseif ($interval->d >= 1) {
			if ($interval->d == 1) {
		 		$time_message = "Yesterday";
		 	}
		 	else {
		 		$time_message = $interval->d . " days ago";
		 	}				
		}
		elseif ($interval->h >= 1) {
			if ($interval->h == 1) {
		 		$time_message = $interval->h . " hour ago";
		 	}
		 	else {
		 		$time_message = $interval->h . " hours ago";
		 	}
		}
		elseif ($interval->i >= 1) {
			if ($interval->i == 1) {
		 		$time_message = $interval->i . " minute ago";
		 	}
		 	else {
		 		$time_message = $interval->i . " minutes ago";
		 	}
		}
		else {
			if ($interval->s < 30) {
		 		$time_message = "Just now";
		 	}
		 	else {
		 		$time_message = $interval->s . " seconds ago";
		 	}
		}

		$user_obj = new User($con, $posted_by);

		?>
		<div class="comment_section ">
			<div class="image-text-comment">
				<a href="<?php echo $posted_by; ?>" target="_parent"><img src="<?php echo $user_obj->getProfilePic(); ?>" title="<?php echo $posted_by; ?>" /></a><br>
				<div class="name-comment-body">
					<a href="<?php echo $posted_by; ?>" target="_parent"><?php echo $user_obj->getFirstAndLastName(); ?></a>
					<p><?php echo $time_message ?></p>
				</div>
			</div>
			<p class="body-text-comment"><?php echo $comment_body ?></p>
			
		</div>		
		<?php
	}
}
else {
	echo "<div style='text-align: center; color: var(--small-heading);'><br /><br />No comments to show.</div>";
}
?>

<?php  

include("includes/footer.php");

?>





</body>
</html>