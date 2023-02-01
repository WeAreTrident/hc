<?php

require 'config/config.php';
include("includes/classes/User.php");
include("includes/classes/Post.php");
include("includes/classes/Notification.php");
include("includes/classes/Project.php");

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
	<link rel="stylesheet" type="text/css" href="assets/css/profile.css">
</head>
<body style="background: transparent !important">

<?php 

// Get id of post
if (isset($_GET['post_id'])) {
	$post_id = $_GET['post_id'];
}

$get_likes = mysqli_query($con, "SELECT likes, added_by FROM project_feed WHERE id='$post_id'");
$row = mysqli_fetch_array($get_likes);
$total_likes = $row['likes'];
$user_liked = $row['added_by'];

$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user_liked'");
$row = mysqli_fetch_array($user_details_query);
$total_user_likes = $row['num_likes'];

// like button
if (isset($_POST['like_button'])) {
	$total_likes++;
	$query = mysqli_query($con, "UPDATE project_feed SET likes='$total_likes' WHERE id='$post_id'");
	//$total_user_likes++;
	//$user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$userLoggedIn'");
	$insert_user = mysqli_query($con, "INSERT INTO project_likes VALUES ('', '$userLoggedIn', '$post_id')");

	// Insert notification
	//if($user_liked != $userLoggedIn) {
	//	$notification = new Notification($con, $userLoggedIn);
//		$notification->insertNotification($post_id, $user_liked, "like");
//	}
}
//unlike button
if (isset($_POST['unlike_button'])) {
	$total_likes--;
	$query = mysqli_query($con, "UPDATE project_feed SET likes='$total_likes' WHERE id='$post_id'");
	//$total_user_likes--;
	//$user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$userLoggedIn'");
	$insert_user = mysqli_query($con, "DELETE FROM project_likes WHERE username='$userLoggedIn' AND post_id='$post_id'");

	// Insert notification
}

// check for previous likes
$check_query = mysqli_query($con, "SELECT * FROM project_likes WHERE username='$userLoggedIn' AND post_id='$post_id'");
$num_rows = mysqli_num_rows($check_query);

if ($num_rows > 0) {
	echo '<form action="project_like.php?post_id=' . $post_id . '" method="POST" class="like_form">
			<button type="submit" class="comment_unlike" name="unlike_button">Unlike</button>
			<div class="like_value">
				<div class="like-amount">' .$total_likes .' </div>
			</div>
			</form>
	';
}
else {
	echo '<form action="project_like.php?post_id=' . $post_id . '" method="POST" class="like_form">
			<button type="submit" class="comment_like" name="like_button">Like</button>
			<div class="like_value">
				<div class="like-amount">' .$total_likes .'</div>
			</div>
			</form>
	';
}

?>

</body>
</html>