<?php  

include("includes/header.php");
include("includes/form_handlers/settings_handler.php");
require_once('includes/google_functions.php');
require_once('includes/microsoft_functions.php');

?>

<br>
<div class="container">
	<div class="row">

        <?php if(isSet($_GET['google-scope-error'])): ?>
                <div class="alert alert-danger">
                    <p class="text-center m-0">Your Google Calendar account could not be connected, please ensure you approve all scopes & permissions when connecting the account.</p>
                </div>
            <?php elseif(isSet($_GET['google-connected'])): ?>
                <div class="alert alert-success">
                    <p class="text-center m-0">Your Google Calendar account has been connected.</p>
                </div>
            <?php elseif(isSet($_GET['google-already-connected'])): ?>
                <div class="alert alert-warning">
                    <p class="text-center m-0">Your Google Calendar account is already connected and active.</p>
                </div>
            <?php elseif(isSet($_GET['google-disconnected'])): ?>
                <div class="alert alert-success">
                    <p class="text-center m-0">Your Google Calendar account has been disconnected.</p>
                </div>
            <?php elseif(isSet($_GET['microsoft-scope-error'])): ?>
                <div class="alert alert-danger">
                    <p class="text-center m-0">Your 365 Calendar account could not be connected, please ensure you approve all scopes & permissions when connecting the account.</p>
                </div>
            <?php elseif(isSet($_GET['microsoft-connected'])): ?>
                <div class="alert alert-success">
                    <p class="text-center m-0">Your 365 Calendar account has been connected.</p>
                </div>
            <?php elseif(isSet($_GET['microsoft-already-connected'])): ?>
                <div class="alert alert-warning">
                    <p class="text-center m-0">Your 365 Calendar account is already connected and active.</p>
                </div>
            <?php elseif(isSet($_GET['microsoft-disconnected'])): ?>
                <div class="alert alert-success">
                    <p class="text-center m-0">Your 365 Calendar account has been disconnected.</p>
                </div>
            <?php endif; ?>

			<!-- First Block -->

			<div class="info-account-settings">
				<h3>Account Settings</h3>
				<br>

					<?php  
						$user_data_query = mysqli_query($con, "SELECT first_name, last_name, email, field_of_work, profession, specialty, sub_specialty, preferred_specialism, location, tel_number, primary_language, secondary_languages, company_name, company_size FROM users WHERE username='$userLoggedIn'");
						$row = mysqli_fetch_array($user_data_query);

						$first_name = $row['first_name'];
						$last_name = $row['last_name'];
						$email = $row['email'];
						$field_of_work = $row['field_of_work'];
						$profession = $row['profession'];
						$specialty = $row['specialty'];
						$sub_specialty = $row['sub_specialty'];
						$preferred_specialism = $row['preferred_specialism'];
						$location = $row['location'];
						$tel_number = $row['tel_number'];
						$primary_language = $row['primary_language'];
						$secondary_languages = $row['secondary_languages'];
						$company_name = $row['company_name'];
						$company_size = $row['company_size'];
					?>


				<form action="settings.php" method="POST">
					<div class="row">
						<div class="col-lg-4">
							<label class="settings-label-account">First Name:</label><br><input type="text" name="first_name" value="<?php echo $first_name; ?>" class="settings-input-account"><br />
						</div>
						<div class="col-lg-4">
							<label class="settings-label-account">Last Name:</label><br><input type="text" name="last_name" value="<?php echo $last_name; ?>" class="settings-input-account"><br />
						</div>		
						<div class="col-lg-4">
							<label class="settings-label-account">Email:</label><br><input type="text" name="email" value="<?php echo $email; ?>" class="settings-input-account"><br />
						</div>
						<div class="col-lg-4">
							<label class="settings-label-account">Job Title:</label><br><input type="text" name="field_of_work" value="<?php echo $field_of_work; ?>" class="settings-input-account"><br />
						</div>
						<div class="col-lg-4">
							<label class="settings-label-account">profession:</label><br><input type="text" name="profession" value="<?php echo $profession; ?>" class="settings-input-account"><br />
						</div>

						<div class="col-lg-4">
							<label class="settings-label-account">specialty:</label><br><input type="text" name="specialty" value="<?php echo $specialty; ?>" class="settings-input-account"><br />
						</div>
						<div class="col-lg-4">
							<label class="settings-label-account">sub specialty:</label><br><input type="text" name="sub_specialty" value="<?php echo $sub_specialty; ?>" class="settings-input-account"><br />
						</div>
						<div class="col-lg-4">
							<label class="settings-label-account">preferred specialism:</label><br><input type="text" name="preferred_specialism" value="<?php echo $preferred_specialism; ?>" class="settings-input-account"><br />
						</div>
						<div class="col-lg-4">
							<label class="settings-label-account">location:</label><br><input type="text" name="location" value="<?php echo $location; ?>" class="settings-input-account"><br />
						</div>
						<div class="col-lg-4">
							<label class="settings-label-account">Phone number:</label><br><input type="text" name="tel_number" value="<?php echo $tel_number; ?>" class="settings-input-account"><br />
						</div>
						<div class="col-lg-4">
							<label class="settings-label-account">Primary Language:</label><br><input type="text" name="primary_language" value="<?php echo $primary_language; ?>" class="settings-input-account"><br />
						</div>
						<div class="col-lg-4">
							<label class="settings-label-account">Secondary Language:</label><br><input type="text" name="secondary_languages" value="<?php echo $secondary_languages; ?>" class="settings-input-account"><br />
						</div>
						<div class="col-lg-4">
							<label class="settings-label-account">Company name:</label><br><input type="text" name="company_name" value="<?php echo $company_name; ?>" class="settings-input-account"><br />
						</div>
						<div class="col-lg-4">
							<label class="settings-label-account">Company Size:</label><br><input type="text" name="company_size" value="<?php echo $company_size; ?>" class="settings-input-account"><br />
						</div>
					</div>
					<br>
					<?php  echo $message; ?>
					<button type="submit" name="update_details" id="save_details" class="info settings-submit-account">Update Details</button><br />
				</form>
			</div>	

			<!-- End -->
			<!-- Profile pic block -->

			<div class="info-account-settings">
			<h3>Profile Picture</h3>
			<br>
				<?php  
					echo "<img src='" . $user['profile_pic'] ."' id='small_profile_pics' class='settings-img-account'>";
				?>
				<br>
				<br>
				
				<a href="upload.php" class="">Upload new profile picture</a>
			</div>
			<!-- End -->
			<!-- Second Block -->
			<div class="info-account-settings">
				<h3>Change Password</h3>
					<br>
					<form action="settings.php" method="POST">
						<div class="row">
							<div class="col-lg-4">
								<label class="settings-label-account">Old Password:</label><br> <input type="password" name="old_password" class="settings-input-account"><br />
							</div>
							<div class="col-lg-4">
								<label class="settings-label-account">New Password:</label><br> <input type="password" name="new_password" class="settings-input-account"><br />
							</div>
							<div class="col-lg-4">
								<label class="settings-label-account">Confirm New Password:</label><br> <input type="password" name="new_password_2" class="settings-input-account"><br />
							</div>
						</div>
						<br>
								<?php  echo $password_message; ?>
								<button type="submit" name="change_password" id="change_password" class="info settings-submit-account">Change Password</button><br />
					</form>	
			</div>
			<!-- End -->

			<div class="info-account-settings">
				<h3>Import ICS Calendar Events</h3>
				<br>
				<p>Easily import calendar events from other sources by importing the ICS file.</p>
				<form action="/" method="POST" enctype='multipart/form-data'>
					<input type="file" name="ics" accept="text/calendar" style='padding-left: 0px;'>
					<br/>
					<br/>
					<button type="submit" name="import-ics" class="settings-submit-account">Import Events</button>
				</form>
			</div>
			
			<!-- Third Block -->
			<div class="info-account-settings">
				<h3>Connect Google Calendar</h3>
				<br>
				<form action="settings.php" method="POST">
					<p>Connect your Google Calendar account to sync diary events with the system.</p>
					<?php if (isGoogleConnected()): ?>
						<p><b>Your Google Calendar account is already connected.</b></p>
						<button type="submit" name="disconnect_google_calendar" id="disconnect_google_calendar" class="settings-submit-account">Disonnect Account</button>
					<?php else: ?>
						<button type="submit" name="connect_google_calendar" id="connect_google_calendar" class="settings-submit-account">Connect Account</button>
					<?php endif; ?>
				</form>
			</div>
			<!-- Fourth Block -->
			<div class="info-account-settings">
				<h3>Connect 365 Calendar</h3>
				<br>
				<form action="settings.php" method="POST">
					<p>Connect your 365 Calendar account to sync diary events with the system.</p>
					<?php if (isMicrosoftConnected()): ?>
						<p><b>Your 365 Calendar account is already connected.</b></p>
						<button type="submit" name="disconnect_microsoft_calendar" id="disconnect_microsoft_calendar" class="settings-submit-account">Disonnect Account</button>
					<?php else: ?>
						<button type="submit" name="connect_365_calendar" id="connect_365_calendar" class="settings-submit-account">Connect Account</button>
					<?php endif; ?>
				</form>
			</div>

			<!-- Third Block -->
			<div class="info-account-settings">
				<h3>Close Account</h3>
				<br>
				<form action="settings.php" method="POST">
					<button type="submit" name="close_account" id="close_account" class="settings-submit-account">Close Account</button>
				</form>
			</div>

		
	</div>
</div>
</body>
</html>