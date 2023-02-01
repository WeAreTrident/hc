<?php 

include("includes/header.php");



$user = new User($con, $userLoggedIn);

// AGENDIZE API LOGIN CREDENTIALS
$apiKey = "74b89e453cede8378926d4bb785ef72602da0d19";
$ssoToken = "5b09729a56bfa95b7a0be164e7f1d159f75d3b77ea3cd12dafc3036d70422627";

if (!isset($_GET['start_date']))
{
	// START DATE IS NOT SET, DEFAULT TODAY
	$start_date = date("d-m-Y");
}
else
{
	$exploded_date = explode("-", $_GET['start_date']);
	if (strlen($exploded_date[0]) == 4) {
		// reformat date
		$year = $exploded_date[0];
		$month = $exploded_date[1];
		$day = $exploded_date[2];

		$start_date = $day . "-" . $month . "-" . $year;
	}
	else {
		$start_date = $_GET['start_date'];
	}
}

//$current_user = $userLoggedIn;
$username = $userLoggedIn;
//$user_email = $user->getEmailAddress();
$user_email = "ssk@health-connect.com";
$user_firstname = $user->getFirstName();
$user_lastname = $user->getLastName();
//$wp_user_id = $current_user->ID;

$start_time = "00:00:01";
$end_time = "23:59:59";

$day2 = date('d-m-Y', strtotime("+1 days", strtotime($start_date)));
$day3 = date('d-m-Y', strtotime("+2 days", strtotime($start_date)));

$previous_page = date('d-m-Y', strtotime("-3 days", strtotime($start_date)));
$next_page = date('d-m-Y', strtotime("+3 days", strtotime($start_date)));

$start_date = explode("-", $start_date);
$day2 = explode("-", $day2);
$day3 = explode("-", $day3);

// SET NICE VARIABLE NAMES
$day1_day = $start_date[0];
$day1_month = $start_date[1];
$day1_year = $start_date[2];
$day2_day = $day2[0];
$day2_month = $day2[1];
$day2_year = $day2[2];
$day3_day = $day3[0];
$day3_month = $day3[1];
$day3_year = $day3[2];

$day1 = mktime(0, 0, 0, $day1_month, $day1_day, $day1_year);
$day2 = mktime(0, 0, 0, $day2_month, $day2_day, $day2_year);
$day3 = mktime(0, 0, 0, $day3_month, $day3_day, $day3_year);

$day1_weekday_name = date("l", $day1);
$day1_month_name = date("M", $day1);
$day2_weekday_name = date("l", $day2);
$day2_month_name = date("M", $day2);
$day3_weekday_name = date("l", $day3);
$day3_month_name = date("M", $day3);

// GET ALL ACCOUNTS FROM AGENDIZE
$data = file_get_contents("https://sante.agendize.com/api/2.0/resellers/accounts?apiKey=$apiKey&token=$ssoToken&search=$user_email");
$accounts = json_decode($data);

foreach ($accounts->items as $account) 
{	
	// WP EMAIL MATCHES AGENDIZE - GET COMPANY ID FOR NEXT API CALL
	$company_id = $account->id;
	$company_sso = $account->ssoToken;
}

if (!isset($company_id))
{
	// WORDPRESS USER DOES NOT HAVE AN AGENDIZE ACCOUNT. DISPLAY CONSULTATION SIGN UP PAGE
	header("Location: premium.php");
	exit();
}

// GET BOOKING BUTTON FROM AGENDIZE
$data1 = file_get_contents("https://sante.agendize.com/api/2.1/scheduling/buttons/?apiKey=$apiKey&token=$company_sso");
$booking_buttons = json_decode($data1);

foreach ($booking_buttons->items as $booking_button)
{
	$button_company_id = $booking_button->companyId;
	$button_id = $booking_button->id;
}



?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
<style>
/*body { background-color: #E7EDF2; color: #343643 !important; }
.dates { margin-top: 20px; }
h1, h2, h3 { font-weight: 600; }
.widget { background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(231,237,242,1) 25%); font-family: 'Open Sans' !important; }
a { color: #343643; }
a:hover { text-decoration: none; }
.control-btns { border-radius: 50%; color: #FFF; font-size: 15px; padding: 15px; width: 46px; margin-right: 20px; text-align: center; }
.fa-video { color: #fff; background-color: green; }
.modal-content { background-color: #E7EDF2 !important; }
.modal-title { font-family: 'Montserrat' !important; font-weight: 600 !important; }
.btn-primary { width: 100%; padding: 15px 0; margin-bottom: 30px; background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(231,237,242,1) 25%) !important; border: none !important; color: #333643 !important; border-radius: 20px !important; box-shadow: 4px 4px 9px -3px rgba(0,0,0,0.3) !important; text-transform: uppercase; color: #8DA6BB !important; font-size: 16px !important; }
.btn-info { padding: 15px 20px !important; background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(231,237,242,1) 25%) !important; border: none !important; color: #333643 !important; border-radius: 20px !important; box-shadow: 4px 4px 9px -3px rgba(0,0,0,0.3) !important; text-transform: uppercase; color: #8DA6BB !important; font-size: 16px !important; }
.client_name { line-height: 100px !important; }*/
</style>


<div class="">

    <div id="primary" class="content-area bb-grid-cell">
        <main id="main" class="site-main">
			<div class="row">
				<div class="container">
					<div class="my-news-feed-title">
						<h1>My Appointments</h1>
					</div>
					<?php 
					$bytes = random_bytes(32);
					$new_video_room = bin2hex($bytes);
					?>
					
				</div>
				
			</div>
		
			<div class="container appointments-form-wrapper">
				<form method="GET" action="" class="appointments-form">
					<input class="date-picker-appointments" type="date" id="start" name="start_date" value="< ?php echo $today; ?>" max="< ?php echo $today; ?>">
					


					<button type="submit" class="main-button">Go</button>
				</form>
				<a class="main-button" id="scheduling-<?php echo $button_company_id; ?>" onclick="openScheduling(<?php echo $button_company_id; ?>, {video: '<?php echo $new_video_room; ?>'})" style="cursor : pointer; border: 0"/>Book Appointment</a> <script type="text/javascript">var scheduling = {server: 'client.health-connect.com', button: '<?php echo $button_id; ?>', lang: 'en'};</script> <script type="text/javascript" src="https://client.health-connect.com/web/scheduling.js"></script>	
			</div>

			<div class="container">
			<div class="row dates">


				<div class="col-md-4">
					<div class="row">
						<div class="col-md-12 week-day">
							<h2 class=""><?php echo $day1_weekday_name; ?></h2>
							<h4 class=""><?php echo $day1_day; ?> <?php echo $day1_month_name; ?> <?php echo $day1_year; ?></h4>
						</div>
						<br style="clear: both;" />
					</div>
					
					
<?php

// GET USERS APPOINTMENTS FOR DAY 1
$day1_agendize_date = $day1_year."-".$day1_month."-".$day1_day;
$day1_start = $day1_agendize_date."T".$start_time;
$day1_end = $day1_agendize_date."T".$end_time;

$data2 = file_get_contents("https://sante.agendize.com/api/2.1/scheduling/companies/$button_company_id/appointments/?apiKey=$apiKey&token=$company_sso&startDate=$day1_start&endDate=$day1_end&levelDetail=full");
$day1_appointments = json_decode($data2);

foreach ($day1_appointments->items as $day1_appointment)
{
	
	$appointment_date = niceDateTime($day1_appointment->start->dateTime)[0];
	$appointment_time = niceDateTime($day1_appointment->start->dateTime)[1];
	$appointment_end_time = niceDateTime($day1_appointment->end->dateTime)[1];
	
	$duration = strtotime($appointment_end_time) - strtotime($appointment_time);
	$duration = $duration/60;

	$appointment_id = $day1_appointment->id;
	
	$client_firstname = $day1_appointment->client->firstName;
	$client_lastname = $day1_appointment->client->lastName;
	$client_name = $client_firstname." ".$client_lastname;
	$client_email = $day1_appointment->client->email;
	$staff_firstname = $day1_appointment->staff->firstName;
	$staff_lastname = $day1_appointment->staff->lastName;
	
	$appointment_time = substr($appointment_time, 0, -3);
	
	$video_room_id = $day1_appointment->form[0]->value;
	$video_room_url = "https://consultation.health-connect.com/app/vid/room/?r=".$video_room_id."&u=".$staff_firstname."%20".$staff_lastname."&p=".$client_firstname."%20".$client_lastname."&d=".$staff_firstname."%20".$staff_lastname."&s=".$appointment_time."&du=".$duration."&role=1";
	
	// GET CLIENT DETAILS
	$client_data1 = file_get_contents("https://sante.agendize.com/api/2.0/clients?apiKey=$apiKey&token=$company_sso&search=$client_email");
	$day1_clients = json_decode($client_data1);
	
	foreach ($day1_clients->items as $day1_client)
	{
		$client_telephone = $day1_client->phoneNumbers[0]->number;
		if (isset($day1_client->picture->url))
		{
			$client_picture = $day1_client->picture->url;
			$client_picture = str_replace("https://sante.agendize.com", "https://client.health-connect.com", $client_picture);
		}
		else
		{
			$client_picture = "https://my.health-connect.com/wp-content/uploads/2021/02/avatar_ficheclient.png";
		}
	
	?>

	<div class="widget appointment-card">
		<div class="appointment-card-wrapper">
			<div class="appointment-card-wrapper-left">
				<?php echo "<img src=".$client_picture." />"; ?>
				<button type="button" class="" data-toggle="modal" data-target="#profile-<?php echo $appointment_id; ?>">Profile</button>
			</div>
			<div class="appointment-card-content">
				<h2><?php echo $client_name; ?></h2>
				<h3><i class="far fa-clock"></i> <?php echo $appointment_time; ?></h3>
				
				<a href="mailto:<?php echo $client_email; ?>"><strong><i class="fas fa-envelope"></i></strong> <?php echo $client_email; ?></a><br />
				<a href="tel:<?php echo $client_telephone; ?>"><strong><i class="fas fa-phone"></i></strong> <?php echo $client_telephone; ?></a><br />
				<a href="<?php echo $video_room_url; ?>" target="_blank"><strong><i class="fas fa-video control-btns"></i></strong> Video Link</a><br />
			</div>
		</div>
		<div class="modal fade" id="profile-<?php echo $appointment_id; ?>" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Patient Profile</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-8">
								<div class="row">
									<div class="col-md-3">
										<img src="<?php echo $client_picture; ?>" />
									</div>
									<div class="col-md-9">
										<h3 class="client_name"><?php echo $client_name; ?></h3>
									</div>
									<br style="clear: both;" />
								</div>
								
							</div>
							<div class="col-md-4">
								<button class="btn btn-lg btn-primary">Pathology Reports</button>
								<button class="btn btn-lg btn-primary">X-Ray Files</button>
								<button class="btn btn-lg btn-primary">Dental Records</button>
								<button class="btn btn-lg btn-primary">Prescriptions</button>
								<button class="btn btn-lg btn-primary">Notes</button>
								
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>		
	</div>
	<?php
	}
}

?>
			</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-12 week-day">
							<h2 class=""><?php echo $day2_weekday_name; ?></h2>
							<h4 class=""><?php echo $day2_day; ?> <?php echo $day2_month_name; ?> <?php echo $day2_year; ?></h4>
						</div>
						<br style="clear: both;" />
					</div>
					
<?php

// GET USERS APPOINTMENTS FOR DAY 2
$day2_agendize_date = $day2_year."-".$day2_month."-".$day2_day;
$day2_start = $day2_agendize_date."T".$start_time;
$day2_end = $day2_agendize_date."T".$end_time;

$data3 = file_get_contents("https://sante.agendize.com/api/2.1/scheduling/companies/$button_company_id/appointments/?apiKey=$apiKey&token=$company_sso&startDate=$day2_start&endDate=$day2_end&levelDetail=full");
$day2_appointments = json_decode($data3);

foreach ($day2_appointments->items as $day2_appointment)
{
	
	$appointment_date = niceDateTime($day2_appointment->start->dateTime)[0];
	$appointment_time = niceDateTime($day2_appointment->start->dateTime)[1];
	$appointment_end_time = niceDateTime($day2_appointment->end->dateTime)[1];
	
	$duration = strtotime($appointment_end_time) - strtotime($appointment_time);
	$duration = $duration/60;

	$appointment_id = $day2_appointment->id;
	
	$client_firstname = $day2_appointment->client->firstName;
	$client_lastname = $day2_appointment->client->lastName;
	$client_name = $client_firstname." ".$client_lastname;
	$client_email = $day2_appointment->client->email;
	$staff_firstname = $day2_appointment->staff->firstName;
	$staff_lastname = $day2_appointment->staff->lastName;
	
	$appointment_time = substr($appointment_time, 0, -3);
	
	$video_room_id = $day2_appointment->form[0]->value;
	$video_room_url = "https://consultation.health-connect.com/app/vid/room/?r=".$video_room_id."&p=".$client_firstname."%20".$client_lastname."&d=".$staff_firstname."%20".$staff_lastname."&s=".$appointment_time."&du=".$duration."&role=1";
	
	// GET CLIENT DETAILS
	$client_data2 = file_get_contents("https://sante.agendize.com/api/2.0/clients?apiKey=$apiKey&token=$company_sso&search=$client_email");
	$day2_clients = json_decode($client_data2);
	
	foreach ($day2_clients->items as $day2_client)
	{
		$client_telephone = $day2_client->phoneNumbers[0]->number;
		if (isset($day2_client->picture->url))
		{
			$client_picture = $day2_client->picture->url;
			$client_picture = str_replace("https://sante.agendize.com", "https://client.health-connect.com", $client_picture);
		}
		else
		{
			$client_picture = "https://my.health-connect.com/wp-content/uploads/2021/02/avatar_ficheclient.png";
		}
	
	?>
<!-- **************************** -->
<!-- 	Appointment card -->
<!-- **************************** -->


	<div class="widget appointment-card">
		<div class="appointment-card-wrapper">
			<div class="appointment-card-wrapper-left">
				<?php echo "<img src=".$client_picture." />"; ?>
				<button type="button" class="" data-toggle="modal" data-target="#profile-<?php echo $appointment_id; ?>">Profile</button>
			</div>
			<div class="appointment-card-content">
				<h2><?php echo $client_name; ?></h2>
				<h3><i class="far fa-clock"></i> <?php echo $appointment_time; ?></h3>
				
				<a href="mailto:<?php echo $client_email; ?>"><strong><i class="fas fa-envelope"></i></strong> <?php echo $client_email; ?></a><br />
				<a href="tel:<?php echo $client_telephone; ?>"><strong><i class="fas fa-phone"></i></strong> <?php echo $client_telephone; ?></a><br />
				<a href="<?php echo $video_room_url; ?>" target="_blank"><strong><i class="fas fa-video control-btns"></i></strong> Video Link</a><br />
			</div>
		</div>
		<div class="modal fade" id="profile-<?php echo $appointment_id; ?>" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Patient Profile</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-8">
								<div class="row">
									<div class="col-md-3">
										<img src="<?php echo $client_picture; ?>" />
									</div>
									<div class="col-md-9">
										<h3 class="client_name"><?php echo $client_name; ?></h3>
									</div>
									<br style="clear: both;" />
								</div>
							
							</div>
							<div class="col-md-4">
								<button class="btn btn-lg btn-primary">Pathology Reports</button>
								<button class="btn btn-lg btn-primary">X-Ray Files</button>
								<button class="btn btn-lg btn-primary">Dental Records</button>
								<button class="btn btn-lg btn-primary">Prescriptions</button>
								<button class="btn btn-lg btn-primary">Notes</button>
								
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>		
	</div>

	<style>

	body {
		background: #f7f8fb;
	}

		
	</style>

	<!-- **************************** -->
<!-- 	End Appointment card -->
<!-- **************************** -->


	<?php
	}
}

?>					
					
				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-12 week-day">
							<h2 class=""><?php echo $day3_weekday_name; ?></h2>
							<h4 class=""><?php echo $day3_day; ?> <?php echo $day3_month_name; ?> <?php echo $day3_year; ?></h4>
						</div>
					
					</div>
					
<?php

// GET USERS APPOINTMENTS FOR DAY 3
$day3_agendize_date = $day3_year."-".$day3_month."-".$day3_day;
$day3_start = $day3_agendize_date."T".$start_time;
$day3_end = $day3_agendize_date."T".$end_time;

$data4 = file_get_contents("https://sante.agendize.com/api/2.1/scheduling/companies/$button_company_id/appointments/?apiKey=$apiKey&token=$company_sso&startDate=$day3_start&endDate=$day3_end&levelDetail=full");
$day3_appointments = json_decode($data4);

foreach ($day3_appointments->items as $day3_appointment)
{
	
	$appointment_date = niceDateTime($day3_appointment->start->dateTime)[0];
	$appointment_time = niceDateTime($day3_appointment->start->dateTime)[1];
	$appointment_end_time = niceDateTime($day3_appointment->end->dateTime)[1];
	
	$duration = strtotime($appointment_end_time) - strtotime($appointment_time);
	$duration = $duration/60;

	$appointment_id = $day3_appointment->id;
	
	$client_firstname = $day3_appointment->client->firstName;
	$client_lastname = $day3_appointment->client->lastName;
	$client_name = $client_firstname." ".$client_lastname;
	$client_email = $day3_appointment->client->email;
	$staff_firstname = $day3_appointment->staff->firstName;
	$staff_lastname = $day3_appointment->staff->lastName;
	
	$appointment_time = substr($appointment_time, 0, -3);
	
	$video_room_id = $day3_appointment->form[0]->value;
	$video_room_url = "https://consultation.health-connect.com/app/vid/room/?r=".$video_room_id."&p=".$client_firstname."%20".$client_lastname."&d=".$staff_firstname."%20".$staff_lastname."&s=".$appointment_time."&du=".$duration."&role=1";
	
	// GET CLIENT DETAILS
	$client_data3 = file_get_contents("https://sante.agendize.com/api/2.0/clients?apiKey=$apiKey&token=$company_sso&search=$client_email");
	$day3_clients = json_decode($client_data3);
	
	foreach ($day3_clients->items as $day3_client)
	{
		$client_telephone = $day3_client->phoneNumbers[0]->number;
		if (isset($day3_client->picture->url))
		{
			$client_picture = $day3_client->picture->url;
			$client_picture = str_replace("https://sante.agendize.com", "https://client.health-connect.com", $client_picture);
		}
		else
		{
			$client_picture = "https://my.health-connect.com/wp-content/uploads/2021/02/avatar_ficheclient.png";
		}
	
	?>


	<?php
	}
}

?>					
					
					
				</div>
			</div>
				<br style="clear: both;" />
			</div>
			
			
        </main><!-- #main -->
    </div><!-- #primary -->

    <div class="pagnation-buttons container">
	    <a class="next-pagnation" href="?start_date=<?php echo $previous_page; ?>"><i class="fas fa-arrow-left"></i></a>
	    <a class="next-pagnation" href="?start_date=<?php echo $next_page; ?>"><i class="fas fa-arrow-right"></i></a>
    </div>
    </div>

<?php

include("includes/footer.php");

?>