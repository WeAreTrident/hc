<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
		<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/style-sign-up.css">

    <title>Register</title>

	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
  </head>
<body>

<?php  

//error_reporting(0);

include("config/config.php");

if (isset($_POST['register_btn'])) {

	$_SESSION['location'] = strip_tags($_POST['location']);
	$_SESSION['newsletter'] = strip_tags($_POST['newsletter']);
	$_SESSION['gdpr'] = strip_tags($_POST['gdpr']);
	$_SESSION['date_of_birth'] = strip_tags($_POST['date_of_birth']);
	$_SESSION['specialty2'] = strip_tags($_POST['specialty2']);
	$_SESSION['preferred_specialism2'] = strip_tags($_POST['preferred_specialism2']);
	$_SESSION['grade_band'] = strip_tags($_POST['grade_band']);
	$_SESSION['qualifications'] = strip_tags($_POST['qualifications']);
	$_SESSION['dbs'] = strip_tags($_POST['dbs']);
	$_SESSION['criminal_convictions'] = strip_tags($_POST['criminal_convictions']);
	$_SESSION['gmc'] = strip_tags($_POST['gmc']);
	$_SESSION['primary_language'] = strip_tags($_POST['primary_language']);
	$_SESSION['secondary_languages'] = strip_tags($_POST['secondary_languages']);
	$_SESSION['cv_upload'] = $_POST['cv_upload'];
	$_SESSION['contact_preference'] = strip_tags($_POST['contact_preference']);
	$_SESSION['company_name'] = strip_tags($_POST['company_name']);
	$_SESSION['company_size'] = strip_tags($_POST['company_size']);
	$_SESSION['service_start'] = strip_tags($_POST['service_start']);
	$_SESSION['user_role'] = $_POST['user_role'];


	/******* SET NICE VARIABLE NAMES FOR INSERT QUERY ******/
	$first_name = $_SESSION['first_name'];
	$first_name = ucfirst(strtolower($first_name));

	$last_name = $_SESSION['last_name'];
	$last_name = ucfirst(strtolower($last_name));

	$username = strtolower($first_name)."_".strtolower($last_name);

	$email_address = $_SESSION['email_address'];
	$password = md5($_SESSION['password']);
	$signup_date = $date = date("Y-m-d");

	// profile pic assignment
	$rand = rand(1, 2);

	if ($rand == 1) {
		$profile_pic = "assets/images/profile_pics/defaults/head_deep_blue.png";
	}
	elseif ($rand == 2) {
		$profile_pic = "assets/images/profile_pics/defaults/head_emerald.png";
	}

	$dashboard_grid = '["1","2","3","4","5"]';

	$tel_number = $_SESSION['tel_number'];
	$user_role = $_SESSION['user_role'];
	$field_of_work = $_SESSION['field_of_work'];
	$profession = $_SESSION['profession'];
	$specialty = $_SESSION['specialty'];
	$sub_specialty = $_SESSION['sub_specialty'];
	$preferred_specialism = $_SESSION['preferred_specialism'];
	$location = $_SESSION['location'];
	$newsletter = $_SESSION['newsletter'];
	$gdpr = $_SESSION['gdpr'];
	$allergies = $_SESSION['allergies'];
	$medical_conditions = $_SESSION['medical_conditions'];
	$services_interested_in = $_SESSION['services_interested_in'];
	$date_of_birth = $_SESSION['date_of_birth'];
	$specialty2 = $_SESSION['specialty2'];
	$preferred_specialism2 = $_SESSION['preferred_specialism2'];
	$grade_band = $_SESSION['grade_band'];
	$qualifications = $_SESSION['qualifications'];
	$dbs = $_SESSION['dbs'];
	$criminal_convictions = $_SESSION['criminal_convictions'];
	$gmc = $_SESSION['gmc'];
	$primary_language = $_SESSION['primary_language'];
	$secondary_languages = $_SESSION['secondary_languages'];
	$cv_upload = $_SESSION['cv_upload'];
	$contact_preference = $_SESSION['contact_preference'];
	$company_name = $_SESSION['company_name'];
	$company_size = $_SESSION['company_size'];
	$service_start = $_SESSION['service_start'];

	mysqli_query($con, "INSERT INTO users VALUES ('','$first_name','$last_name','$username','$email_address','$password','$signup_date','$profile_pic', '0', '0', 'no',',','','$dashboard_grid','$tel_number','$user_role','$field_of_work','$profession','$specialty','$sub_specialty','$preferred_specialism', '$location','$newsletter','$gdpr','$allergies','$medical_conditions','$services_interested_in','$date_of_birth','$specialty2','$preferred_specialism2','$grade_band','$qualifications','$dbs','$criminal_convictions','$gmc','$primary_language','$secondary_languages','$cv_upload','$contact_preference','$company_name','$company_size','$service_start')") or die(mysqli_error($con));

	?>
	<section class="sign-up-background " style="background-image: url('assets/images/backgrounds/blob-background-new.png');">
	
		<div class="container elem to-fade-in">
			<div class="thank-you">
				<h1 class="sign-up-title">Thank you</h1>
				<h3>Thank you for your application. We aim to review all applications within 24 hours. You will receive an e-mail to confirm this once your application has been reviewed.</h3>
			</div>
		</div>
	</section>	

	<?php

}

elseif ($_POST['s'] == 2) {
	// step 2
	
	$_SESSION['first_name'] = strip_tags($_POST['first_name']);
	$_SESSION['last_name'] = strip_tags($_POST['last_name']);
	$_SESSION['email_address'] = strip_tags($_POST['email_address']);
	$_SESSION['tel_number'] = strip_tags($_POST['tel_number']);
	$_SESSION['password'] = strip_tags($_POST['password']);
	$_SESSION['password1'] = strip_tags($_POST['password1']);

	?>

	<!-- ************************* -->
	<!-- ********* Category ****** -->
	<!-- ************************* -->

<section class="sign-up-background" style="background-image: url('assets/images/backgrounds/blob-background-new.png');">
	<div class="container elem to-fade-in">
		<div class="row">
			<div class="step-by-step-align">
				<div class="sign-up-step-by-step active" >
					<h2><i class="fa fa-check"></i></h2>
					<p>Personal</p>
				</div>
				<div class="sign-up-step-by-step " >
					<h2>2</h2>
					<p>Category</p>
				</div>
				<div class="sign-up-step-by-step" >
					<h2>3</h2>
					<p>Chosen Category</p>
				</div>
				<div class="sign-up-step-by-step" >
					<h2>4</h2>
					<p>Additional Information</p>
				</div>
				<div class="sign-up-step-by-step" >
					<h2>5</h2>
					<p>Finish</p>
				</div>
				
			</div>
		</div>
	</div>
	<div class="container" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="5000">
		<h1 class="sign-up-title">Are you a...</h1>
			<form method="POST" action="">
			    <div class="row" >
					<div class="col-lg-4">
					    <button class="professional-option" type="submit" name="user_role" value="Professional">Professional</button>
					</div>
					<div class="col-lg-4">
				        <button class="professional-option" type="submit" name="user_role" value="Provider">Provider</button>
					</div>
					<div class="col-lg-4">
				        <button class="professional-option" type="submit" name="user_role" value="Corporation">Corporation</button>
					</div>
					<div class="col-lg-4">
				        <button class="professional-option" type="submit" name="user_role" value="CQC">CQC</button>
					</div>
					<div class="col-lg-4">
				        <button class="professional-option" type="submit" name="user_role" value="Individual">Individual</button>
					</div>
					<div class="col-lg-4">
				        <button class="professional-option" type="submit" name="user_role" value="Service User">Service User</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<div class="container" data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-delay="300" data-aos-offset="0">
		<form>
 			<input class="back-button" type="button" value="Go back!" onclick="history.back()">
		</form>
	</div>
</section>

	<!-- ************************* -->
	<!-- ********* End *********** -->
	<!-- ************************* -->

	<?php
	
}
elseif (isset($_POST['user_role'])) {
	
	$type = $_POST['user_role'];

	if ($type == "Professional") {

		if (isset($_POST['professional_step2'])) {

			// set session variables from previous screen
			$_SESSION['field_of_work'] = strip_tags($_POST['field_of_work']);
			$_SESSION['profession'] = strip_tags($_POST['profession']);
			$_SESSION['preferred_specialism'] = strip_tags($_POST['preferred_specialism']);

			//var_dump($_POST);

			if (!empty($_POST['specialty_doctors'])) {

				// get specialty ID
				if (strlen($_POST['specialty_doctors']) == 17) 
					$specialty_doctors_id = substr($_POST['specialty_doctors'], -1);
				elseif (strlen($_POST['specialty_doctors']) == 18)
					$specialty_doctors_id = substr($_POST['specialty_doctors'], -2);
				else 
					$specialty_doctors_id = substr($_POST['specialty_doctors'], -3);

				$specialty_name_query_dr = mysqli_query($con, "SELECT specialty FROM specialties WHERE id=$specialty_doctors_id") or die(mysqli_error($con));
				$row = mysqli_fetch_array($specialty_name_query_dr);
				$specialty = $row['specialty'];

				// check sub_specialties
				$check_sub_specialties_query_1 = mysqli_query($con, "SELECT id, sub_specialty FROM sub_specialties") or die(mysqli_error($con)); 
				while ($row = mysqli_fetch_array($check_sub_specialties_query_1)) {

					$session_var_id = "dr_subspecialty_" . $row['id'];
					
					if ($_POST[$session_var_id] != "")
						$sub_specialty = $_POST[$session_var_id];
				}
			}

			if (!empty($_POST['specialty_nurses'])) {

				// get specialty ID
				if (strlen($_POST['specialty_nurses']) == 20) 
					$specialty_nurses_id = substr($_POST['specialty_nurses'], -1);
				elseif (strlen($_POST['specialty_nurses']) == 21)
					$specialty_nurses_id = substr($_POST['specialty_nurses'], -2);
				else 
					$specialty_nurses_id = substr($_POST['specialty_nurses'], -3);

				$specialty_name_query_nurse = mysqli_query($con, "SELECT specialty FROM specialties WHERE id=$specialty_nurses_id") or die(mysqli_error($con));
				$row = mysqli_fetch_array($specialty_name_query_nurse);
				$specialty = $row['specialty'];

				// check sub_specialties
				$check_sub_specialties_query_2 = mysqli_query($con, "SELECT id, sub_specialty FROM sub_specialties") or die(mysqli_error($con)); ;
				while ($row = mysqli_fetch_array($check_sub_specialties_query_2)) {

					$session_var_id = "nurse_subspecialty_" . $row['id'];

					if ($_POST[$session_var_id] != "") {
						$sub_specialty = $_POST[$session_var_id];
					}

				}
			}
			
			if (!empty($_POST['specialty_diet_fitness'])) {

				// get specialty ID
				if (strlen($_POST['specialty_diet_fitness']) == 26) 
					$specialty_dietfitness_id = substr($_POST['specialty_diet_fitness'], -1);
				elseif (strlen($_POST['specialty_diet_fitness']) == 27)
					$specialty_dietfitness_id = substr($_POST['specialty_diet_fitness'], -2);
				else 
					$specialty_dietfitness_id = substr($_POST['specialty_diet_fitness'], -3);

				$specialty_name_query_dietfitness = mysqli_query($con, "SELECT specialty FROM specialties WHERE id=$specialty_dietfitness_id") or die(mysqli_error($con));
				$row = mysqli_fetch_array($specialty_name_query_dietfitness);
				$specialty = $row['specialty'];

				// check sub_specialties
				$check_sub_specialties_query_3 = mysqli_query($con, "SELECT id, sub_specialty FROM sub_specialties") or die(mysqli_error($con)); ;
				while ($row = mysqli_fetch_array($check_sub_specialties_query_3)) {

					$session_var_id = "dietfitness_subspecialty_" . $row['id'];

					if ($_POST[$session_var_id] != "") {
						$sub_specialty = $_POST[$session_var_id];
					}
				}
			}

			if (!empty($_POST['specialty_mentalhealth'])) {

				// get specialty ID
				if (strlen($_POST['specialty_mentalhealth']) == 27) 
					$specialty_mentalhealth_id = substr($_POST['specialty_mentalhealth'], -1);
				elseif (strlen($_POST['specialty_mentalhealth']) == 28) 
					$specialty_mentalhealth_id = substr($_POST['specialty_mentalhealth'], -2);
				else 
					$specialty_mentalhealth_id = substr($_POST['specialty_mentalhealth'], -3);

				$specialty_name_query_mentalhealth = mysqli_query($con, "SELECT specialty FROM specialties WHERE id=$specialty_mentalhealth_id") or die(mysqli_error($con));
				$row = mysqli_fetch_array($specialty_name_query_mentalhealth);
				$specialty = $row['specialty'];

				// check sub_specialties
				$check_sub_specialties_query_4 = mysqli_query($con, "SELECT id, sub_specialty FROM sub_specialties") or die(mysqli_error($con)); ;
				while ($row = mysqli_fetch_array($check_sub_specialties_query_4)) {

					$session_var_id = "mentalhealth_subspecialty_" . $row['id'];

					if ($_POST[$session_var_id] != "") {
						$sub_specialty = $_POST[$session_var_id];
					}
				}
			}
			
			$_SESSION['specialty'] = $specialty;
			$_SESSION['sub_specialty'] = $sub_specialty;

			?>
	<section class="sign-up-background" style="background-image: url('assets/images/backgrounds/blob-background-new.png');">
		<div class="container elem to-fade-in">
			<div class="row">
				<div class="step-by-step-align">
					<div class="sign-up-step-by-step active" >
						<h2><i class="fa fa-check"></i></h2>
						<p>Personal</p>
					</div>
					<div class="sign-up-step-by-step active" >
						<h2><i class="fa fa-check"></i></h2>
						<p>Category</p>
					</div>
					<div class="sign-up-step-by-step active" >
						<h2><i class="fa fa-check"></i></h2>
						<p>Chosen Category</p>
					</div>
					<div class="sign-up-step-by-step" >
						<h2>4</h2>
						<p>Additional Information</p>
					</div>
					<div class="sign-up-step-by-step" >
						<h2>5</h2>
						<p>Finish</p>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="5000">
			<div class="row">
			<h1 class="sign-up-title">Additional Information</h1>
				<div class="col-lg-6">
					<form method="POST" action="">
					<input class="input-field-sign-up" placeholder="Location" type="text" name="location"><br>
					<p class="check-box-heading">Newsletter:</p> <input type="checkbox" class="toggle" name="newsletter"><br>
					<p class="check-box-heading">GDPR Declaration:</p> <input type="checkbox" class="toggle" name="gdpr"><br>
					<input placeholder="Date of Birth" class="input-field-sign-up" type="date" value="2017-06-01" name="date_of_birth"><br>
					<input placeholder="Specialty" class="input-field-sign-up" type="text" name="specialty2"><br>
					<input placeholder="Preferred Specialism" class="input-field-sign-up" type="text" name="preferred_specialism2"><br>

					<!-- note for Adam: do not display these two fields if fitness or wellbeing professional -->
					<input placeholder="Grade/Band" class="input-field-sign-up" type="text" name="grade_band"><br>
					<input placeholder="Qualifications" class="input-field-sign-up" type="text" name="qualifications"><br>

					<button class="input-field-sign-up-button" type="submit" name="register_btn">Register</button>
				</div>
				<div class="col-lg-6">
					<input placeholder="DBS" class="input-field-sign-up" type="text" name="dbs"><br>
					<input placeholder="Criminal Convictions" class="input-field-sign-up" type="text" name="criminal_convictions"><br>

					<!-- note for Adam: do not display this field if fitness professional -->
					<input placeholder="GMC/Professional Pin" class="input-field-sign-up" type="text" name="gmc"><br>


					<input placeholder="Primary/Preferred Spopken Language" class="input-field-sign-up" type="text" name="primary_language"><br>
					<input placeholder="Secondary languages" class="input-field-sign-up" type="text" name="secondary_languages"><br>
					<input placeholder="CV Upload" class="input-field-sign-up" type="file" name="cv_upload"><br>
					<!-- <input placeholder="How would you like to be contacted? Message/Email/Phone" class="input-field-sign-up" type="text" name="contact_preference"> -->
					<p>How would you like to be contacted?</p>
				  <input type="radio" id="Message" name="contact_preference" value="Message">
				  <label for="Message">Message</label><br>
				  <input type="radio" id="Email" name="contact_preference" value="Email">
				  <label for="Email">Email</label><br>  
				  <input type="radio" id="Phone" name="contact_preference" value="Phone">
				  <label for="Phone">61 - 100</label><br><br>
				</div>
			</div>
		</div>
		<div class="container" data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-delay="300" data-aos-offset="0">
			<input type="hidden" name="user_role" value="Professional">
			<input class="back-button" type="button" value="Go back!" onclick="window.history.go(-3)">
			</form>
			<br>
			<br>
			<br>
		</div>
		</section>
			
			<?php

		}
		else {		

		?>

	<!-- ************************* -->
	<!-- ****** Professional ***** -->
	<!-- ************************* -->

	<section class="sign-up-background" style="background-image: url('assets/images/backgrounds/blob-background-new.png');">
		<div class="container elem to-fade-in">
				<div class="row">
					<div class="step-by-step-align">
						<div class="sign-up-step-by-step active" >
							<h2><i class="fa fa-check"></i></h2>
							<p>Personal</p>
						</div>
						<div class="sign-up-step-by-step active" >
							<h2><i class="fa fa-check"></i></h2>
							<p>Category</p>
						</div>
						<div class="sign-up-step-by-step" >
							<h2>3</h2>
							<p>Professional</p>
						</div>
						<div class="sign-up-step-by-step" >
							<h2>4</h2>
							<p>Additional Information</p>
						</div>
						<div class="sign-up-step-by-step" >
							<h2>5</h2>
							<p>Finish</p>
						</div>
						
					</div>
				</div>
			</div>

			<div class="container" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="5000">
				<div class="row">
					<div class="col-lg-5">
			<h1 class="sign-up-title">Professional</h1>
			<br>
			<p><strong>What field do you work in?</strong></p>
			<form method="POST" action="">
			<select class="select-field-options" name="field_of_work">
				<option selected value=""> -- select an option -- </option>
				<option value="Psychology and Therapy">Psychology & Therapy</option>
				<option value="Fitness">Fitness</option>
				<option value="Diet and Health">Diet and Health</option>
				<option value="Fertility and Pregnancy">Fertility and Pregnancy</option>
				<option value="Wellbeing">Wellbeing</option>
				<option value="Cosmetics and Plastics">Cosmetics and Plastics</option>
				<option value="Child and Adolescent Mental Health">Child and Adolescent Mental Health</option>
				<option value="Doctors">Doctors</option>
				<option value="Mental Health">Mental Health</option>
			</select>
			
			<p><strong>My profession is:</strong></p>
			<select  class="select-field-options seeAnotherField" name="profession" >
				<option selected value=""> -- select an option -- </option>
				<option value="Doctor">Doctor</option>
				<option value="Nurse">Nurse</option>
				<option value="Diet and Fitness">Diet and Fitness</option>
				<option value="Mental Health">Mental Health</option>
			</select>

			<!-- The select boxes below need to display depending on the above selection -->
			
				<div class="otherFieldDiv"> 
					<p><strong>Specialty:</strong></p>
					<select id="specialty_doctors" class="select-field-options" name="specialty_doctors">
						<option selected value=""> -- select an option -- </option>
						<?php

							$doctors_sub_specialties = array();				

							$query = mysqli_query($con, "SELECT * FROM specialties WHERE field='Doctors'");
							while($row = mysqli_fetch_array($query)) {
								echo "<option value='dr_subspecialty_" . $row['id'] ."'>" . $row['specialty'] ."</option>";
								$specialty_id = $row['id'];
								$dr_sub_query = mysqli_query($con, "SELECT * FROM sub_specialties WHERE specialty_id=$specialty_id");
								if (mysqli_num_rows($dr_sub_query) > 0) {
									// FOUND RESULTS - ADD ID TO ARRAY
									array_push($doctors_sub_specialties, $specialty_id);
								}
							}
						?>
					</select>
				</div>

				<div class="otherFieldDivTwo"> 
					<div id="doctors_sub_specialties">
						<?php
						if (count($doctors_sub_specialties) > 0) {
						
							foreach($doctors_sub_specialties as $subspecialty_id) {
								// GET ALL SUB SPECIALTIES
								$query = mysqli_query($con, "SELECT * FROM sub_specialties WHERE specialty_id=$subspecialty_id");
								echo "<select style='display:none;' class='select-field-options testing-field' id='dr_subspecialty_" . $subspecialty_id ."' name='dr_subspecialty_" . $subspecialty_id ."'>
								<option selected value=''>Select a Sub Specialty</option>";

								while($row = mysqli_fetch_array($query)) {
									echo " <option value='" . $row['sub_specialty'] ."'>" . $row['sub_specialty'] ."</option>";
								}
								echo "</select>";

								echo "<script>
								$('#specialty_doctors').on('change', function() {
								  
								  if ($(this).val() == 'dr_subspecialty_" . $subspecialty_id ."') {
								    $('#dr_subspecialty_" . $subspecialty_id ."').css('display', 'block');
								  }
								  else {
									$('#dr_subspecialty_" . $subspecialty_id ."').css('display', 'none');
								  }
								});</script>";
							}
						}
					?>
				</div>
			</div>
				
			<div class="otherFieldDivNurse"> 
				<p ><strong>Specialty</strong></p>
				<select class="select-field-options" name="specialty_nurses">
				<option selected value=""> -- select an option -- </option>

					<?php

						$nurses_sub_specialties = array();

						$query = mysqli_query($con, "SELECT * FROM specialties WHERE field='Nurses'");

						while($row = mysqli_fetch_array($query)) {
							
							echo "<option value='nurse_subspecialty_" . $row['id'] ."'>" . $row['specialty'] ."</option>";
							$specialty_id = $row['id'];
							$nurse_sub_query = mysqli_query($con, "SELECT * FROM sub_specialties WHERE specialty_id=$specialty_id");
							if (mysqli_num_rows($nurse_sub_query) > 0) {
								// FOUND RESULTS - ADD ID TO ARRAY
								array_push($nurses_sub_specialties, $specialty_id);
							}
						}
					?>
				</select>
			</div>
				<div id="nurses_sub_specialties">
				<?php
		
				if (count($nurses_sub_specialties) > 0) {
					foreach ($nurses_sub_specialties as $subspecialty_id) {
						// GET ALL SUB SPECIALTIES
						$query = mysqli_query($con, "SELECT * FROM sub_specialties WHERE specialty_id=$subspecialty_id");
						echo "<select class='select-field-options select-field' id='nurse_subspecialty_" . $subspecialty_id ."' name='nurse_subspecialty_" . $subspecialty_id ."'>
						<option selected value=''>Select a Sub Specialty</option>";
											
						while($row = mysqli_fetch_array($query)) {
							echo "<option value='" . $row['sub_specialty'] ."'>" . $row['sub_specialty'] ."</option>";
						}
						echo "</select>";

						echo "<script>
						$('#specialty_doctors').on('change', function() {
						  
						  if ($(this).val() == 'nurse_subspecialty_" . $subspecialty_id ."') {
							$('#nurse_subspecialty_" . $subspecialty_id ."').css('display', 'block');
						  }
						  else {
							$('#nurse_subspecialty_" . $subspecialty_id ."').css('display', 'none');
						  }
						});</script>";
					}
				}

				?>
				</div>

			<div class="otherFieldDivDiet"> 
				<p><strong>Specialty</strong></p>
				<select class="select-field-options" name="specialty_diet_fitness">
				<option selected value=""> -- select an option -- </option>

					<?php

						$dietfitness_sub_specialties = array();

						$query = mysqli_query($con, "SELECT * FROM specialties WHERE field='Diet and Fitness'");
						while($row = mysqli_fetch_array($query)) {
							echo "<option value='dietfitness_subspecialty_" . $row['id'] ."'>" . $row['specialty'] ."</option>";
							$specialty_id = $row['id'];
							$dietfitness_sub_query = mysqli_query($con, "SELECT * FROM sub_specialties WHERE specialty_id=$specialty_id");
							if (mysqli_num_rows($dietfitness_sub_query) > 0) {
								// FOUND RESULTS - ADD ID TO ARRAY
								array_push($dietfitness_sub_specialties, $specialty_id);
							}
						}
					?>
				</select>
			</div>

			<div id="dietfitness_sub_specialties">
			<?php
		
			if (count($dietfitness_sub_specialties) > 0) {
				foreach ($dietfitness_sub_specialties as $subspecialty_id) {
					// GET ALL SUB SPECIALTIES
					$query = mysqli_query($con, "SELECT * FROM sub_specialties WHERE specialty_id=$subspecialty_id");
					echo "<select class='select-field-options select-field' id='dietfitness_subspecialty_" . $subspecialty_id ."' name='dietfitness_subspecialty_" . $subspecialty_id ."'>
					<option selected value=''>Select a Sub Specialty</option>";				
					while($row = mysqli_fetch_array($query)) {
						echo "<option value='" . $row['sub_specialty'] ."'>" . $row['sub_specialty'] ."</option>";
					}
					echo "</select>";
					echo "<script>
					$('#specialty_doctors').on('change', function() {
					  
					  if ($(this).val() == 'dietfitness_subspecialty_" . $subspecialty_id ."') {
						$('#dietfitness_subspecialty_" . $subspecialty_id ."').css('display', 'block');
					  }
					  else {
						$('#dietfitness_subspecialty_" . $subspecialty_id ."').css('display', 'none');
					  }
					});</script>";
				}
			}

			?>
			</div>

			<div class="otherFieldDivMental"> 
				<p><strong>Specialty</strong></p>
				<select class="select-field-options" name="specialty_mentalhealth">
				<option selected value=""> -- select an option -- </option>

					<?php
						$mentalhealth_sub_specialties = array();

						$query = mysqli_query($con, "SELECT * FROM specialties WHERE field='Mental Health'");
						while($row = mysqli_fetch_array($query)) {
							echo "<option value='mentalhealth_subspecialty_" . $row['id'] ."'>" . $row['specialty'] ."</option>";
							$specialty_id = $row['id'];
							$mentalhealth_sub_query = mysqli_query($con, "SELECT * FROM sub_specialties WHERE specialty_id=$specialty_id");
							if (mysqli_num_rows($mentalhealth_sub_query) > 0) {
								// FOUND RESULTS - ADD ID TO ARRAY
								array_push($mentalhealth_sub_specialties, $specialty_id);
							}
						}
					?>		
				</select>
			</div>

			<div id="mentalhealth_sub_specialties">
				<?php
					if (count($mentalhealth_sub_specialties) > 0) {
						foreach ($mentalhealth_sub_specialties as $subspecialty_id) {
							// GET ALL SUB SPECIALTIES
							$query = mysqli_query($con, "SELECT * FROM sub_specialties WHERE specialty_id=$subspecialty_id");
							echo "<select class='select-field-options select-field' id='mentalhealth_subspecialty_" . $subspecialty_id ."' name='mentalhealth_subspecialty_" . $subspecialty_id ."'>
							<option selected value=''>Select a Sub Specialty</option>";

							while($row = mysqli_fetch_array($query)) {
								echo "<option value='" . $row['sub_specialty'] ."'>" . $row['sub_specialty'] ."</option>";
							}
							echo "</select>";
							echo "<script>
							$('#specialty_doctors').on('change', function() {
							  
							  if ($(this).val() == 'mentalhealth_subspecialty_" . $subspecialty_id ."') {
								$('#mentalhealth_subspecialty_" . $subspecialty_id ."').css('display', 'block');
							  }
							  else {
								$('#mentalhealth_subspecialty_" . $subspecialty_id ."').css('display', 'none');
							  }
							});</script>";
						}
					}
				?>
			
			</div>
			<input class="input-field-sign-up" placeholder="Preferred Specialism:" type="text" name="preferred_specialism"><br>
			<input type="hidden" name="user_role" value="Professional">
			<input class="back-button" type="button" value="Start again!" onclick="window.history.go(-3)">
			<button class="input-field-sign-up-button" type="submit" name="professional_step2">Next</button>
				</form>
			</div>
			<div class="col-lg-7">
				<div class="sign-up-image-position">
					<img src="https://health-connect.sagraphicswebproofs.co.uk/wp-content/uploads/2021/10/App-build.gif">
				</div>
			</div>
			</div>
			</div>
				<!-- <div class="container">
					<form>
						<input class="back-button" type="button" value="Start again!" onclick="window.history.go(-3)">
					</form>
				</div> -->
				<br>
				<br>
				<br>
				<br>
			</section>

	<!-- ************************* -->
	<!-- ********* end *********** -->
	<!-- ************************* -->
			<?php
		}
	}

	if ($type == "Corporation") {

		if (isset($_POST['company_lead'])) {
			?>
			<section class="sign-up-background" style="background-image: url('assets/images/backgrounds/blob-background-new.png');">

				<div class="container elem to-fade-in">
					<div class="row">
						<div class="step-by-step-align">
							<div class="sign-up-step-by-step active" >
								<h2><i class="fa fa-check"></i></h2>
								<p>Personal</p>
							</div>
							<div class="sign-up-step-by-step active" >
								<h2><i class="fa fa-check"></i></h2>
								<p>Category</p>
							</div>
							<div class="sign-up-step-by-step active" >
								<h2><i class="fa fa-check"></i></h2>
								<p>Corporation</p>
							</div>
							<div class="sign-up-step-by-step" >
								<h2>4</h2>
								<p>Company Lead</p>
							</div>
							<div class="sign-up-step-by-step" >
								<h2>5</h2>
								<p>Finish</p>
							</div>
						</div>
					</div>
				</div>
				<div class="container" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="5000" >
					<h1 class="sign-up-title">Company lead</h1>
					<div class="row">
						<div class="col-lg-5">

							<form method="POST" action="">
								<input class="input-field-sign-up" placeholder="Location" type="text" name="location"><br>
								<p class="check-box-heading">Newsletter:</p> <input type="checkbox" class="toggle" name="newsletter"><br>
								<p class="check-box-heading">GDPR Declaration:</p> <input type="checkbox" class="toggle" name="gdpr"><br>
								<input class="input-field-sign-up" placeholder="Company Name" type="text" name="company_name"><br>
								<input class="input-field-sign-up" placeholder="Industry" type="text" name="industry"><br>
								<input class="input-field-sign-up" placeholder="Company Size" type="text" name="company_size"><br>
								<input class="input-field-sign-up" placeholder="When would you like to start the service?" type="text" name="service_start"><br>
								<button class="input-field-sign-up-button" type="submit" name="register_btn">Sign Up</button>
							</form>
						
						</div>
						<div class="col-lg-7">
							<div class="sign-up-image-position">
								<img src="https://health-connect.sagraphicswebproofs.co.uk/wp-content/uploads/2021/11/Gif-38.gif">
							</div>
						</div>
					</div>
				</div>
				<div class="container" data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-delay="300" data-aos-offset="0">
					<form>
						<input class="back-button" type="button" value="Start again!" onclick="window.history.go(-3)">
						
					</form>
					<br>
					<br>
					<br>
				</div>
			</section>
			
			
			<?php
		}

		elseif (isset($_POST['employee'])) {
			?>
			<section class="sign-up-background" style="background-image: url('assets/images/backgrounds/blob-background-new.png');">

				<div class="container elem to-fade-in">
					<div class="row">
						<div class="step-by-step-align">
							<div class="sign-up-step-by-step active" >
								<h2><i class="fa fa-check"></i></h2>
								<p>Personal</p>
							</div>
							<div class="sign-up-step-by-step active" >
								<h2><i class="fa fa-check"></i></h2>
								<p>Category</p>
							</div>
							<div class="sign-up-step-by-step active" >
								<h2><i class="fa fa-check"></i></h2>
								<p>Corporation</p>
							</div>
							<div class="sign-up-step-by-step" >
								<h2>4</h2>
								<p>Employee</p>
							</div>
							<div class="sign-up-step-by-step" >
								<h2>5</h2>
								<p>Finish</p>
							</div>
						</div>
					</div>
				</div>

				<div class="container" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="5000" >
					<h1 class="sign-up-title">Employee</h1>
					<div class="row">
						<div class="col-lg-5">
							<form method="POST" action="">
								<input class="input-field-sign-up" placeholder="Location" type="text" name="location"><br>
								<p class="check-box-heading">Newsletter:</p> <input type="checkbox" class="toggle" name="newsletter"><br>
								<input class="input-field-sign-up" placeholder="Allergies" type="text" name="allergies"><br>
								<input class="input-field-sign-up" placeholder="Medical Conditions" type="text" name="medical_conditions"><br>
								<input class="input-field-sign-up" placeholder="Services I am interested in" type="text" name="services_interested_in"><br>
								<input class="input-field-sign-up" placeholder="Company Name" type="text" name="company_name"><br>
								<button class="input-field-sign-up-button" type="submit" name="register_btn">Sign Up</button>
							</form>
						</div>
						<div class="col-lg-7">
							<div class="sign-up-image-position">
								<img src="https://health-connect.sagraphicswebproofs.co.uk/wp-content/uploads/2021/11/Gif-38.gif">
							</div>
						</div>
					</div>
				</div>
				<div class="container" data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-delay="300" data-aos-offset="0">
					<form>
						<input class="back-button" type="button" value="Start again!" onclick="window.history.go(-2)">
						
					</form>
					<br>
					<br>
					<br>
				</div>
			</section>
			<?php
		}
		else {

		?>

<section class="sign-up-background" style="background-image: url('assets/images/backgrounds/blob-background-new.png');">

	<div class="container elem to-fade-in">
		<div class="row">
			<div class="step-by-step-align">
				<div class="sign-up-step-by-step active" >
					<h2><i class="fa fa-check"></i></h2>
					<p>Personal</p>
				</div>
				<div class="sign-up-step-by-step active" >
					<h2><i class="fa fa-check"></i></h2>
					<p>Category</p>
				</div>
				<div class="sign-up-step-by-step active" >
					<h2><i class="fa fa-check"></i></h2>
					<p>Corporation</p>
				</div>
				<div class="sign-up-step-by-step" >
					<h2>4</h2>
					<p>Personal</p>
				</div>
				<div class="sign-up-step-by-step" >
					<h2>5</h2>
					<p>Personal</p>
				</div>
				<div class="sign-up-step-by-step" >
					<h2>6</h2>
					<p>Personal</p>
				</div>
				<div class="sign-up-step-by-step" >
					<h2>7</h2>
					<p>Personal</p>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<h1 class="sign-up-title">Corporation</h1>
			<br>
			<form method="POST" action="">
			<input type="hidden" name="user_role" value="Corporation">
			<div class="row">
				<div class="col-lg-6">
					<input type="submit" class="employee-or-company" id="employee" name="employee" value="Employee">
				</div>
				<div class="col-lg-6">
					<input type="submit" class="employee-or-company" id="company_lead" name="company_lead" value="Company Lead">
				</div>	
		</div>
		</form>
	</div>
	<br>
	<div class="container" data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-delay="300" data-aos-offset="0">
		<form>
			<input class="back-button" type="button" value="Go back!" onclick="history.back()">
		</form>
		<br>
		<br>
		<br>
	</div>

</section>
		<?php
		}
	}

	if ($type == "Provider") {

		?>
	<section class="sign-up-background" style="background-image: url('assets/images/backgrounds/blob-background-new.png');">

		<div class="container elem to-fade-in">
			<div class="row">
				<div class="step-by-step-align">
					<div class="sign-up-step-by-step active provider">
						<h2><i class="fa fa-check"></i></h2>
						<p>Personal</p>
					</div>
					<div class="sign-up-step-by-step active provider">
						<h2><i class="fa fa-check"></i></h2>
						<p>Category</p>
					</div>
					<div class="sign-up-step-by-step">
						<h2>3</h2>
						<p>Provider</p>
					</div>
					<div class="sign-up-step-by-step">
						<h2>4</h2>
						<p>Finish</p>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
			<h1 class="sign-up-title">Provider</h1>
				<div class="col-lg-5">
					<form method="POST" action="">
					<input class="input-field-sign-up" placeholder="Location" type="text" name="location"><br>
					<p class="check-box-heading">Newsletter:</p> <input type="checkbox" class="toggle" name="newsletter"><br>
					<p class="check-box-heading">GDPR Declaration:</p> <input type="checkbox" class="toggle" name="gdpr"><br>
					<input class="input-field-sign-up" placeholder="Company Name" type="text" name="company_name"><br>
					<input class="input-field-sign-up" placeholder="Company Size" type="text" name="company_size">
					<p class="check-box-heading">When would you like to start the service?</p>
					<select class="select-field-options" name="service_start">
						<option value="As soon as possible">As soon as possible</option>
						<option value="1-3 months">1-3 months</option>
						<option value="3-6 months">3-6 months</option>
						<option value="6 months+">6 months+</option>
						<option value="Unsure">Unsure</option>
					</select>
					<input type="hidden" name="user_role" value="Provider">
					<button class="input-field-sign-up-button" type="submit" name="register_btn">Sign Up</button>
					</form>
				</div>
				<div class="col-lg-7">
					<div class="sign-up-image-position">
						<img src="https://health-connect.sagraphicswebproofs.co.uk/wp-content/uploads/2021/10/App-build.gif">
					</div>
				</div>
			</div>
		</div>
		<div class="container" data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-delay="300" data-aos-offset="0">
			<form>
				<input class="back-button" type="button" value="Start again!" onclick="window.history.go(-2)">
				
			</form>
			<br>
			<br>
			<br>
		</div>
	</section>

		<?php
	}

	if ($type == "CQC") {

		echo "CQC stuff goes here";

	}

	if ($type == "Individual") {

		echo "Individual stuff goes here";

	}

	if ($type == "Service User") {

		echo "Service User stuff goes here";

	}
}
else {
	// step 1
?>

	<!-- ************************* -->
	<!-- ********* Personal ****** -->
	<!-- ************************* -->

<section class="sign-up-background" style="background-image: url('assets/images/backgrounds/blob-background-new.png');">

	<div class="container elem to-fade-in">
		<div class="row">
			<div class="step-by-step-align">
				<div class="sign-up-step-by-step " >
					<h2>1</h2>
					<p>Personal</p>
				</div>
				<div class="sign-up-step-by-step " >
					<h2>2</h2>
					<p>Category</p>
				</div>
				<div class="sign-up-step-by-step" >
					<h2>3</h2>
					<p>Chosen Category</p>
				</div>
				<div class="sign-up-step-by-step" >
					<h2>4</h2>
					<p>Additional Information</p>
				</div>
				<div class="sign-up-step-by-step" >
					<h2>5</h2>
					<p>Finish</p>
				</div>
			</div>
		</div>
	</div>

	<div class="container" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="5000" >
		<div class="row">
			<h1 class="sign-up-title">Personal Details</h1>
			<div class="col-lg-6">
				<div class="sign-up-form-1">
					<form method="POST" action="">
						<input class="input-field-sign-up" placeholder="First Name..." type="text" name="first_name" value="<?php echo $_SESSION['first_name']; ?>"><br>
						<input class="input-field-sign-up" placeholder="Last Name..." type="text" name="last_name" value="<?php echo $_SESSION['last_name']; ?>"><br>
						<input class="input-field-sign-up" placeholder="Email Address..." type="text" name="email_address" value="<?php echo $_SESSION['email_address']; ?>"><br>
						<input class="input-field-sign-up" placeholder="Mobile (incl. country code)" type="text" name="tel_number" value="<?php echo $_SESSION['tel_number']; ?>"><br>
						<input class="input-field-sign-up" placeholder="Password..." type="password" name="password"><br>
						<input class="input-field-sign-up" placeholder="Confirm Password..." type="password" name="password1"><br>
						<div class="font-style">
							<i class="fa fa-arrow-left left" aria-hidden="true"></i><input class="back-button" type="button" value="Go back!" onclick="history.back()">
							<button class="input-field-sign-up-button" name="s" value="2">Next   <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
						</div>
						
					</form>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="sign-up-image-position">
					<img src="https://health-connect.sagraphicswebproofs.co.uk/wp-content/uploads/2021/10/message.gif">
				</div>
			</div>
		</div>
	</div>

	<!-- <div class="container" data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-delay="300" data-aos-offset="0">
		<form>
 			<input class="back-button" type="button" value="Go back!" onclick="history.back()">
		</form>
	</div> -->
</section>
	<!-- ************************* -->
	<!-- ********* end *********** -->
	<!-- ************************* -->

<?php

}

?>
			<!-- ***************************** -->
			<!-- Javascript hide select field  -->
			<!-- ***************************** -->
<!-- Doctor -->
<script>
		$(".seeAnotherField").change(function() {
		if ($(this).val() == "Doctor") {
			$('.otherFieldDiv').show();
			$('.otherFieldDivTwo').show();
			
		} else {
			$('.otherFieldDiv').hide();
			$('.otherFieldDivTwo').hide();
			
		}
		if ($(this).val() == "Nurse") {
			$('.otherFieldDivNurse').show();
			
		} else {
			$('.otherFieldDivNurse').hide();
			
		}
		if ($(this).val() == "Diet and Fitness") {
			$('.otherFieldDivDiet').show();
			
		} else {
			$('.otherFieldDivDiet').hide();
			
		}
		if ($(this).val() == "Mental Health") {
			$('.otherFieldDivMental').show();
			
		} else {
			$('.otherFieldDivMental').hide();
			
		}
		});
		
		$(".seeAnotherField").trigger("change");

// Nurses
</script>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script>
		function checkElementLocation() {
	  var $window = $(window);
	  var bottom_of_window = $window.scrollTop() + $window.height();

	  $('.elem').each(function(i) {
	    var $that = $(this);
	    var bottom_of_object = $that.position().top + $that.outerHeight();

	    //if element is in viewport, add the animate class
	    if (bottom_of_window > bottom_of_object) {
	      $(this).addClass('fade-in');
	    }
	  });
	}
	// if in viewport, show the animation
	checkElementLocation();

	$(window).on('scroll', function() {
	  checkElementLocation();
	});
</script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>