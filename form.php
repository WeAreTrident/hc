<?php  

include("includes/header.php");

?>

<style type='text/css'>
	form#fb-render h1 {
		font-size: 21px;
	}

	#fb-render input[type='file'] {
		background: transparent;
		box-shadow: none;
	}

	#fb-render button {
		background: linear-gradient( 129deg,rgba(73,190,255,1) 0%,rgba(128,72,255,1) 100%);
		border: none;
		color: #fff;
		text-decoration: none;
		padding: 15px 30px;
		border-radius: 30px;
		text-align: center;
		width: auto;
		text-transform: uppercase;
	}

	#fb-render button#submit {
		margin-top: 20px;
		margin-left: auto;
		margin-right: auto;
		display: block;
	}

	#fb-render [readonly]:not(button) {
		background: #f8f8f8;
		cursor: not-allowed;
		pointer-events:none;
	}

	a.viewResponse {
		padding: 5px 20px;
		font-size: 14px;
		vertical-align: middle;
	}

	.form-header-wrapper input, .form-header-wrapper select {
		padding: 3px 10px;
		border: 1px solid #ccc;
		min-width: 260px;
	}

	.form-header-wrapper button {
		padding: 5px 15px;
		font-size: 14px;
		margin-left: 5px;
	}

	tr.viewing {
		background-color: #e0ebf7;
	}

	p.response-area-title {
		font-weight: bold;
		font-size: 18px;
		margin-bottom: 0;
	}

	.cqc-wrapper {
		display: inline-block;
		vertical-align: top;
		margin: 0 10px;
		text-align: center;
	}

	.cqc-wrapper *:not(:first-child) {
		font-size: 12px;
		display: inline-block;
		vertical-align: middle;
		margin-bottom: 0;
		margin: 0 1px;
	}

	.cqc-wrapper p:first-child {
		font-size: 14px;
		margin-top: -19px;
		margin-bottom: 0;
	}

	.view-form-response-file {
		display: block;
		color: #6387ff;
	}
</style>

<?php

echo "<br><br><div class='container'>";

if (isset($_GET) && isSet($_POST) && count($_POST)>0) {

	echo "<br><br>";

	$fileCount=0;
	foreach($_FILES as $k=>$file) {
		$fileCount++;
		$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
		$filename = $_SESSION['username'].'-'.$fileCount.'.'.$extension;
		move_uploaded_file($_FILES[$k]["tmp_name"], 'uploads/form-uploads/'.$filename);
		$_POST[$k] = $filename;
	}

	$form_response = serialize($_POST);
	$form_id = $_GET['id'];
	
	$date_added = date("Y-m-d H:i:s");
	$submitted_by = $userLoggedIn;

	$query = "INSERT INTO form_responses VALUES ('', '$form_response', '$submitted_by', '$date_added', '$form_id')";
	mysqli_query($con, $query);
	//header("Location: form.php?id=$form_id");
}

if (isset($_GET['id'])) {
	$form_id = $_GET['id'];

	$query = mysqli_query($con, "SELECT * FROM forms WHERE id='$form_id'");

	if($row = mysqli_fetch_array($query)) {

		$form_data = $row['form_data'];

		if(isSet($_GET['response'])) {
			$rq = mysqli_query($con, "SELECT * FROM form_responses WHERE form_id='$_GET[id]' AND id='$_GET[response]' ORDER BY date DESC");
			$rq = mysqli_fetch_array($rq);
			$rq_form = unserialize($rq['form_response']);
			$form_data = json_decode($form_data, true);
			foreach($form_data as $fdk=>$fdv) {
				$element_name = $fdv['name'];
				if(array_key_exists($element_name, $rq_form)) {
					// die(var_dump($element_name, $rq_form, $rq_form['autocomplete-1648048282885-0'], $rq_form[$element_name]));
					$form_data[$fdk]['value'] = $rq_form[$element_name];
				}
			}
			$form_data = json_encode($form_data);
		}

		echo "<br/><br /><h1 class='form-render-title'>" . $row['form_name'] . "</h1><br>";
		echo "<form id='fb-render' action='#' method='POST' enctype=\"multipart/form-data\"></form>
		<script>
		jQuery(function($) {
		  var fbRender = document.getElementById('fb-render'),
		    formData = '" . $form_data ."';

		  var formRenderOpts = {
		    formData,
		    dataType: 'json'
		  };

		  $(fbRender).formRender(formRenderOpts);
		";
		if (!isSet($_GET['response'])) {
		  echo "$(fbRender).append('<input type=\"submit\" class=\"main-button\" name=\"submit\" style=\"margin:auto;margin-top:15px;display:block;\">');";
		}else
			echo "$(fbRender).find('input,textarea,button,select').attr('readonly','readonly');";
		
		if (isSet($_GET['response'])): ?>
			$("input[type='file'][value]").each(function() {
				var value = $(this).attr('value');
				$(this).hide();
				$("<a href='/form-file.php?form=<?php echo $_GET['id']; ?>&response=<?php echo $_GET['response']; ?>&file="+btoa(value)+"' target='_blank' class='view-form-response-file'>"+value+"</a>").insertAfter($(this));
			});
		<?php endif;
		
		echo " });	</script>";
			echo "<br><p class='response-area-title'>Form Responses</p>";
		// echo "<hr>";

		$response_query = mysqli_query($con, "SELECT * FROM form_responses WHERE form_id='$_GET[id]' ORDER BY date DESC");
		if (mysqli_num_rows($response_query) > 0) {

			echo "<table class='table'><thead><tr><td><strong>Submitted On</strong></td><td><strong>Submitted By</strong></td><td></td>";

			// Get headings from the form to display in the table
			$query = mysqli_query($con, "SELECT form_data FROM forms WHERE id='$_GET[id]'");
			$row = mysqli_fetch_array($query);
			$form_data = json_decode($row['form_data'], true);

			echo "</tr></thead><tbody>";

			while ($response_row = mysqli_fetch_array($response_query)) {
				// Display form submissions
				$form_response = unserialize($response_row['form_response']);
				array_pop($form_response); // removes last item in array - the hidden field for the ID
				$submitted_by = $response_row['submitted_by'];
				$date_submitted = date("j/m/Y H:ia", strtotime($response_row['date']));

				$user_obj = new User($con, $submitted_by);
				$submitted_by_name = $user_obj->getFirstAndLastName();
				$submitted_by_pic = $user_obj->getProfilePic();

				$rowClass = '';
				if($_GET['response'] == $response_row['id'])
					$rowClass = 'viewing';

				echo "<tr class=\"".$rowClass."\">";
				echo "<td>" . $date_submitted . "</td>";
				echo "<td><a style='text-decoration:none;' href='" . $submitted_by ."'><img src='" . $submitted_by_pic ."' height='30' style='border-radius:100%;'> " . $submitted_by_name ."</a></td>";
				echo "<td><a href='/form.php?id=".$response_row['form_id']."&response=".$response_row['id']."' class='viewResponse main-button'>View Details</a></td>";

				// foreach($form_response as $value) {
				// 	echo "<td>" . $value . "</td>";
				// }

				echo "</tr>";
			}

			echo "</tbody></table>";
		}else
			echo "<p><i>There are no form responses just yet...</i></p>";

	}
	else {
		header("Location: form.php");
	}
}
else {

	$query = mysqli_query($con, "SELECT * FROM forms ORDER BY id DESC LIMIT 1");
	$row = mysqli_fetch_array($query);
	$next_id = $row['id']+1;

	if (isset($_GET['type'])) {
		$type = $_GET['type'];
	}

?>
	<div class="container">
		<h1 class="form-title">Create a New Form</h1>
		<br>
		<div class="input-form-wrapper form-header-wrapper">
			<input type="text" name="form_name" id="form_name" placeholder="Enter a name for your new form..." class="form-input" />
			<div class="slide-slider-2 cqc-wrapper">
				<p>Share with CQC?</p>
				<p class="">No</p>
				<label id="switch" class="switch">
				<input type="checkbox" id="cqc" name='cqc'>
					<span class="slider round"></span>
				</label>
				<p class="">Yes</p>
			</div>
			<select name="form_category" id="form-category" class="form-category">
				<option value="">Form Category...</option>
				<option value="Care Plan"<?php if ($type == "Care Plan") echo " selected"; ?>>Care Plan</option>
				<option value="Clinical Formulation"<?php if ($type == "Clinical Formulation") echo " selected"; ?>>Clinical Formulation</option>
				<option value="Health and Safety Audit"<?php if ($type == "Health and Safety Audit") echo " selected"; ?>>Health and Safety Audit</option>
                <option value="Incident Reports"<?php if ($type == "Incident Reports") echo " selected"; ?>>Incident Reports</option>
                <option value="Initial Assessment"<?php if ($type == "Initial Assessment") echo " selected"; ?>>Initial Assessment</option>
				<option value="Medication Audit"<?php if ($type == "Medication Audit") echo " selected"; ?>>Medication Audit</option>
				<option value="Risk Assessment"<?php if ($type == "Risk Assessment") echo " selected"; ?>>Risk Assessment</option>
				<option value="Training Audit"<?php if ($type == "Training Audit") echo " selected"; ?>>Training Audit</option>
				<option value="Weight Chart"<?php if ($type == "Weight Chart") echo " selected"; ?>>Weight Chart</option>
			</select>
			<button id="addField" name="addField" class='main-button'>Save</button>
			<button id="saveData" name="saveData" class='main-button' style="display: none;">Submit</button>
			<br/>
			<br/>
			<div class="team-member-forms">
				<div class="team-member-reminder-settings-container">
					<p>Team members...</p>
					<div>
						Remind the team every <input type="number" min="1" max="31" placeholder="X" id="reminderOne"> <select id="reminderTwo"><option value="day">Days</option><option value="week">Weeks</option><option value="month">Months</option></select>
					</div>
				</div>
				<div class="team-members-on-form">
					<div class="form-existing-team-members"></div>
					<div class="add-team-member-container">
						<?php $u = $_SESSION['username']; ?>
						<input type="text" onkeyup="getLiveSearchUsers(this.value, '<?php echo $u; ?>', $('.team_search_results_form'), $('.team_search_results_form_footer'))" name="form_team_search" id="form_team_search" placeholder="Add a team member..." class="form-input form-team-search" />
						<div class="team_search_results_form"></div>
						<div class="team_search_results_form_footer"></div>
					</div>
				</div>
			</div>
			<script type="text/javascript">
				$(document).on('click', '.team_search_results_form .resultDisplay a', function(e) {
					e.preventDefault();
					e.stopPropagation();
					addTeamMember($(this));
					return false;
				});

				$(document).on('click', '.form-existing-team-members a', function(e) {
					e.preventDefault();
					e.stopPropagation();
					$(this).remove();
					return false;
				});

				function addTeamMember(member) {
					$('.form-existing-team-members').append(member);
					$('.form-team-search').val('').trigger('keyup');
				}
			</script>
			<style type="text/css">
				.team_search_results_form .resultDisplay {display: inline-block;margin: 0 10px 10px 0;width: 240px;}
				.form-existing-team-members a {display: inline-block;width: 240px;margin: 0 10px 10px;vertical-align: top;text-decoration:none;}
				.team_search_results_form {margin-top: 10px;}
				.team_search_results_form_footer {display: none !important;}
				.team-member-forms {background: white;padding: 10px;border-radius: 15px;border: 1px solid #ccc;}
				.add-team-member-container {background: #f8f8f8;padding: 10px;border-radius: 5px;}
				.add-team-member-container input {margin-top: 10px;width: 50%;}
				.form-existing-team-members a:hover * {color: red;}
				.team-member-reminder-settings-container>* {display: inline-block;width: 49.80%;}
				.team-member-reminder-settings-container>div {text-align: right;font-size: 12px;}
				.team-member-reminder-settings-container input, .team-member-reminder-settings-container select {min-width: 100px;max-width: 100px;height: 30px;font-size: 12px;text-align: center;margin-left: 5px;}
			</style>
		</div>
		<br>
		<div id="fb-editor"></div>


	</div>
	<br>
	<br>
	<script>
		Array.prototype.move = function(from, to) {
			this.splice(to, 0, this.splice(from, 1)[0]);
		};

	jQuery(function($) {
		$(document).on('click', '#fb-render button#submit', function() {$(this).closest('form').submit();});

		var options = {
			disabledActionButtons: ['data'],
			showActionButtons: false,
			enable: true, 
			disableFields: ['hidden'],
			disableHTMLLabels: true

			// Add a default submit button to the bottom of new forms, removed in favour of template-based default instead so it can't be edited/removed/reordered.
			// defaultFields: [{
			// 	type: 'input',
			// 	class: 'form-control',
			// 	name: 'submit',
			// 	value: 'Submit',
			// 	label: 'Submit'
			// }],
			// 'onAddField': function(fieldId) {
			// 	if (!window.formbuilder || !window.formbuilder.actions || !window.formbuilder.actions.showData)
			// 		return;
			// 	setTimeout(function () {
			// 		var data = window.formbuilder.actions.getData();
			// 		var lastElement = data[data.length - 1];
			// 		if (lastElement['name'] != 'submit') {
			// 			var submitElement = null;
			// 			for (var i=0;i<data.length;i++) {
			// 				if (submitElement)
			// 					continue;
			// 				var d = data[i];
			// 				if (d['name'] == 'submit')
			// 					submitElement = i;
			// 			}
			// 			data.move(submitElement, data.length-1);
			// 			$('.field-actions>.del-button.btn.formbuilder-icon-cancel.delete-confirm').click();
			// 			window.formbuilder.actions.setData(data);
			// 		}
			// 	}, 25);
			// },
		};

		var formBuilder = $(document.getElementById('fb-editor')).formBuilder(options);
		var fbEditor = document.getElementById('build-wrap');
		// var formBuilder = $(fbEditor).formBuilder();
		window.formbuilder = formBuilder;

		document.getElementById("addField").addEventListener("click", () => {

			var field = {
				type: 'hidden',
				class: 'form-control',
				name: 'form_id',
				value: '<?php echo $next_id; ?>'
			};

			formBuilder.actions.addField(field, undefined);	

		    var saveButton = document.getElementById("addField");
		    var submitButton = document.getElementById("saveData");

		    saveButton.style.display = "none";
		    submitButton.style.display = "inline-block";				

		});

		document.getElementById("saveData").addEventListener("click", () => {
			var form_data = formBuilder.actions.getData('json');
			var form_name = document.getElementById('form_name').value;
			var category = document.getElementById('form-category').value;
			var cqc = document.getElementById('cqc').value;
			var reminderOne = document.getElementById('reminderOne').value;
			var reminderTwo = document.getElementById('reminderTwo').value;
			var userLoggedIn = '<?php echo $userLoggedIn; ?>';
			
			var teamMembers = '';
			$('.form-existing-team-members a').each(function() {
				if (teamMembers.length > 0)
					teamMembers += ',';
				teamMembers += $(this).attr('href'); // username
			});
			teamMembers = btoa(teamMembers);
			
			request = $.ajax({
		        url: "includes/form_handlers/post_user_form.php",
		        type: "post",
				data: "form_data=" + form_data + "&form_name=" + form_name + "&userLoggedIn=" + userLoggedIn+'&cqc='+cqc+'&category='+category+'&teamMembers='+teamMembers+'&reminderOne='+reminderOne+'&reminderTwo='+reminderTwo,
				success: function(data) {
					window.location.href = "form.php?id=" + data;
				}
		    });
		});
	});
	</script>
<?php  

}

echo "</div>";

include("includes/footer.php");

?>