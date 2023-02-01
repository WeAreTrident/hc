<?php 

error_reporting(0);
include("includes/header.php");

?>
<!-- <style>

.sensor, .time_box {
	border-radius: 20px !important;
    box-shadow: 4px 4px 9px -3px rgb(0 0 0 / 30%) !important;
	border-color: #E7E9EC;
	text-align: center;
	padding: 20px;
	margin: 10px;
	font-weight: bold;
}
.red { color: red; font-size: 40px; }
.green { color: #13C5D1; font-size: 40px; }
.modal-content { background-color: #E7EDF2 !important; }
.modal-title { font-family: 'Montserrat' !important; font-weight: 600 !important; }
.btn-primary { width: 100%; padding: 15px 0; margin-bottom: 30px; background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(231,237,242,1) 25%) !important; border: none !important; color: #333643 !important; border-radius: 20px !important; box-shadow: 4px 4px 9px -3px rgba(0,0,0,0.3) !important; text-transform: uppercase; color: #8DA6BB !important; font-size: 16px !important; }
.btn-info { padding: 15px 20px !important; background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(231,237,242,1) 25%) !important; border: none !important; color: #333643 !important; border-radius: 20px !important; box-shadow: 4px 4px 9px -3px rgba(0,0,0,0.3) !important; text-transform: uppercase; color: #8DA6BB !important; font-size: 16px !important; }
.modal-title { margin-top: 8px; }
</style> -->
<div class="container">
	

<div class="my-news-feed-title">
	<h1>Temperatures</h1>
</div>
<br>

<div class=" wrapper-search-project">
	<input type="text" id="myFilterTemperatures" class="search-service" onkeyup="myFunctionTemperatures()" placeholder="Search...">
</div>
<br>

<div id="temperatureWrapper">
	

<?php

if(isset($_GET['modal'])) {
	$modal = $_GET['modal'];
	$js = "<script>
			$(window).on('load', function(){
				$('#" . $modal . "').modal('show'); 
			});
			</script>";
}

$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://www.imonnit.com/json/SensorListExtended',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => 'POST',
	CURLOPT_HTTPHEADER => array(
		'APIKeyID: Xj8Swxwoa9wu',
		'APISecretKey: mtc9PbNHKcbg0KROguYy5iTE1I3k7ju8',
		'Content-Type: application/json',  
		'Content-Length: 0'
	),
));

$response = curl_exec($curl);

curl_close($curl);

$fridges = json_decode($response, true);

$i = 0;

foreach($fridges as $fridge) {

	if(is_array($fridge)) {
	
		foreach($fridge as $key=>$data) {
			
			$sensor_id = $data['SensorID'];		
			$sensor_name = $data['SensorName'];
			$current_temp = $data['CurrentReading'];
			
			if($i == 0)
				echo "<div class='row'>\n";
			
			if ($i == 4 || $i == 8)
				echo "</div><div class='row'>\n";
			
			$check_temp = substr($current_temp, 0, -3);
			
			// SET WHETHER FRIDGE OR ROOM IN THE IF STATEMENTS BELOW
			
			if ($sensor_id == "835862" || $sensor_id == "838645" || $sensor_id == "838632" || $sensor_id == "838631") {
				
				if($check_temp > 8)
					$icon = "<i class=\"fas fa-exclamation-triangle red\"></i>";
				else
					$icon = "<i class=\"fas fa-check-circle green\"></i>";				

			}
			
			if ($sensor_id == "786303" || $sensor_id == "845515" || $sensor_id == "849793" || $sensor_id == "807277") {
				
				if($check_temp > 24)
					$icon = "<i class=\"fas fa-exclamation-triangle red\"></i>";	
				else
					$icon = "<i class=\"fas fa-check-circle green\"></i>";
			}

			echo "\t\t<div class='col-md-3 fridge'>
					<div class='sensor ". $color ."'>
					<h3 class='sensor-title'>" . $sensor_name . "</h3>
					<p>" . $current_temp . "</p><br />". $icon ."\n\n";

			// GET TEMPERATURE HISTORY FOR PREVIOUS WEEK FOR EACH SENSOR
			
			if(isset($_GET['date'])) {
				$query_date = date("Y-m-d", strtotime($_GET['date']));
			}
			else
				$query_date = date("Y-m-d");
		
			$today = date("Y-m-d");
			$yesterday = date('d-m-Y', strtotime("-1 day", strtotime($query_date)));
			$tomorrow = date('d-m-Y', strtotime("+1 day", strtotime($query_date)));

			$curl = curl_init();

			$url = "https://www.imonnit.com/json/SensorDataMessages?sensorID=".$sensor_id."&fromDate=".$query_date."&toDate=".$query_date;

			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_HTTPHEADER => array(
					'APIKeyID: Xj8Swxwoa9wu',
					'APISecretKey: mtc9PbNHKcbg0KROguYy5iTE1I3k7ju8',
					'Content-Type: application/json',  
					'Content-Length: 0'
				),
			));

			$response = curl_exec($curl);

			curl_close($curl);

			$history_temps = json_decode($response, true);
			
			$display_date = date("D j M Y", strtotime($query_date));
	?>

			<br /><br />
			<!-- Button trigger modal -->
			<button type="button" class="main-button" data-bs-toggle="modal" data-bs-target="#modal<?php echo $sensor_id; ?>">
			  View History 
			</button>

			<!-- Modal -->
			<div class="modal fade" id="modal<?php echo $sensor_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">
					<?php echo $sensor_name ." - ". $display_date; ?>
					</h5>
					<div style="right: 55px; position: absolute;">
					<form method="GET" action="">
					<input type="date" id="start" name="date" value="<?php echo $today; ?>" max="<?php echo $today; ?>">
					<input type="hidden" name="modal" value="modal<?php echo $sensor_id; ?>" />
					<button type="submit" class="button">Go</button>
					</form>
						<!--<a class="button" href="?date=<?php //echo $yesterday; ?>&modal=modal<?php //echo $sensor_id; ?>">Previous</a>
						<a class="button" href="?date=<?php //echo $tomorrow; ?>&modal=modal<?php //echo $sensor_id; ?>">Next</a>-->
					</div>				
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
				  <div class="row text-center" style="margin: auto;">
				  	
					<?php 
							
					foreach($history_temps as $history_temp) {

						foreach($history_temp as $key=>$data) {
							
							$sensor_id = $data['SensorID'];	

							$message_date = $data['MessageDate'];
							$message_date = substr($message_date, 6, -5);
							
							$display_time = date('H:i:s', $message_date);
							
							$temperature = $data['PlotValue'];
							$temp_to_display = $data['DisplayData'];
							
							$check_temp = $temperature;
							
							if ($sensor_id == "835862" || $sensor_id == "838645" || $sensor_id == "838632" || $sensor_id == "838631") {
								
								if($check_temp > 8)
									$icon = "<i class=\"fas fa-exclamation-triangle red\"></i>";
								else
									$icon = "<i class=\"fas fa-check-circle green\"></i>";				

							}
							
							if ($sensor_id == "786303" || $sensor_id == "845515" || $sensor_id == "849793" || $sensor_id == "807277") {
								
								if($check_temp > 24)
									$icon = "<i class=\"fas fa-exclamation-triangle red\"></i>";	
								else
									$icon = "<i class=\"fas fa-check-circle green\"></i>";
							}						
							

							echo "<div class='col-md-3'><div class='time_box'>". $icon ."<br />
									". $display_time . "<br />
									" . $temp_to_display . "<br />
									</div></div>";
							

						}
					}					

					
					?>
					</div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
				  </div>
				</div>
			  </div>
			</div>
			<!-- end temp containers -->
			</div></div>

	<?php		
			$i++;
		}
	}
}

?>
<p class="temperatures-refresh">Temperatures correct as of <?php echo date("d-m-Y H:i:s"); ?> UTC. Please <a href="javascript:location.reload();"><strong>Refresh</strong></a> this page to view the latest data.</p>
</div>

</div></div>
<?php

echo $js;

include("includes/footer.php");

?>

