<?php

require_once('db.php');
require_once('checkAuth.php');
require_once('logout.php');


// Checks if user is logged in, otherwise returns index
if (!$loggedin && !isset($id)) {
	header('Location: login.php');
	return;
}

	$db = db::getInstance();


	// Query to get the user's info if it's his/her own profile
	$sql = "SELECT
				userID,
				password,
					firstName,
					lastName,
					email,
					phone,
					DATE_FORMAT(birth, '%W, %M %e, %Y') as birth,
					address,
					gender
			FROM User
			WHERE userID = {$id};
	";

	$stmt = $db->prepare($sql);
	$stmt->execute();

	$result = $stmt->fetchAll();

	$user = $result[0];


if(!isset($user)){
	header('Location: login.php');
	return;
}
	$manyCars = false;

   $carsql = "SELECT
				V.vehicleID,
				V.userID,
				V.make,
				V.model,
				V.color,
				V.year,
				V.licensePlate,
				V.owner
				FROM Vehicle V
				WHERE V.userID = {$user['userID']};";

	$stmt = $db->prepare($carsql);
	$stmt->execute();

	$vehicles = $stmt->fetchAll();
	$car = $vehicles[0];

	$carID = $car[vehicleID];

	if(!isset($vehicles)){
	header('Location: login.php');
	return;
	}

	$sesssql = "SELECT DISTINCT
					vehicleID,
					date,
					DATE_FORMAT(date, '%W, %M %e, %Y') as day
					FROM Session 
					WHERE vehicleID = {$car['vehicleID']};";
	$stmt = $db->prepare($sesssql);
	$stmt->execute();

	$sessions = $stmt->fetchAll();
	
	$dates = array();
	for ($i = count($sessions) - 1; $i >= 0; $i--){
	 
	 // add each date to the end of the times array
	 $dates[] = array('date' => $sessions[$i]['date'], 'day' => $sessions[$i]['day'] );

	}

	if(!isset($sessions)){
		header('Location: login.php');
		return;
	}


?>
<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title>CarSpy</title>

	<link rel="stylesheet" href="css/normalize.css" />

	<link rel="stylesheet" href="css/app.css" />
	<script src="js/vendor/custom.modernizr.js"></script>
	<script src="/js/vendor/jquery.js"></script>
	<script src="js/foundation/foundation.js"></script> 
	
	<!--
	<script src="js/foundation/foundation.alerts.js"></script>
	<script src="js/foundation/foundation.clearing.js"></script>
	<script src="js/foundation/foundation.cookie.js"></script>
	<script src="js/foundation/foundation.dropdown.js"></script>
	<script src="js/foundation/foundation.forms.js"></script>
	<script src="js/foundation/foundation.joyride.js"></script>
	<script src="js/foundation/foundation.magellan.js"></script>
	<script src="js/foundation/foundation.orbit.js"></script>
	<script src="js/foundation/foundation.placeholder.js"></script>
	<script src="js/foundation/foundation.reveal.js"></script>
	<script src="js/foundation/foundation.section.js"></script>
	<script src="js/foundation/foundation.tooltips.js"></script>
	<script src="js/foundation/foundation.topbar.js"></script> -->
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBYeihJGidZ-x1D2gtw7gy02hC-gNDdW2U&sensor=false"></script>
</head>
<body>

	<div id="topnav">
		 <div id="cslogo">
		 	<a href="/"><img  src="img/CarSpyGray2.png"></a>
			<span>
				<h3 style="margin-top:-45px; margin-right:50px;">Welcome, <a href="profile.php" style="color: #ff7b0d;"><?php echo $user['firstName'] ?> <?php echo $user['lastName'] ?></a></h3>
				
			</span>
			<span style="float: right; margin-right: 50px; margin-top: -20px;">
				
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" >
                                <input type="hidden" value="logout" name="loggedOut" />
                                <input type="hidden" style="color: #32CD32; text-decoration: underline;" value="Log Out" />
                                <a href="#" onclick="this.parentNode.submit()" style="text-align: right; size: 6px; color: gray; ">Log Out</a>
                            </form>

			</span>
		
		</div> 

	</div>
	
	<div class="row">
		<div class="large-12 columns container">
			

					<h3 align="center">Choose An Event:</h3>
					
					
					
			
					<span style="text-align:center; margin-left: 10%; ">
					
					

					<select id="dates" name='date' style="width:40%" class="form-select">
					 	<?php
					 	for ($i = 0; $i<count($dates); $i++){
 
						 // add each date to the end of the times array
						 echo "<option value='{$dates[$i]['date']}'>{$dates[$i]['day']}</option>";
						}
						?>
					</select>
					<select id="times" name="time" class='form-select' style="width:40%">
							
					</select>
					
					
						
					</span>

		</div>
	</div> 

	<div class="row container">
		<div class="large-12">
			<div style="height:300px; padding:5px; ">
				<div id="map_canvas"></div>
			</div>
		</div>
		<div class="large-12 panel" style="width:102%; margin-top:-5px; margin-left:-10px; margin-right:-10px;">
			<div class="ribbon-before"></div>
			<div class="ribbon-after"></div>
			
			<h3>Pictures:</h3>
		</div>
	</div>

	<div class="row container">
		
 		<div class="large-12">

 			<ul id="pics" style="padding-left: 1.5%; padding-top: 1.5%;">
 				<li style="display:inline"><a href="spypics/jpeg_20130321_230845.jpg"><img src="spypics/jpeg_20130321_230845.jpg"></a></li>
 				<li style="display:inline"><a href="spypics/CarSpy2.jpg"><img src="spypics/CarSpy2.jpg"></a></li>
 				<li style="display:inline"><a href="spypics/jpeg_20130326_204341.jpg"><img src="spypics/jpeg_20130326_204341.jpg"></a></li>
			</ul>

 		</div>
<!-- 
		<div class="large-12 panel" style="width:102%; margin-top:-5px; margin-left:-10px; margin-right:-10px;">
			<div class="ribbon-before"></div>
			<div class="ribbon-after"></div>
			
			<h3>Event Info:</h3>
		</div> -->

	</div>
	<!-- 
	<div class="row container">
		<div class="large-12" >
		
			<div class="large-4 columns infopanel" >
				<h4 id="date">Date:</h4>
				
			</div> 
			<div class="large-4 columns infopanel">
				<h4 id="time">Time:</h4>
			</div> 
			<div class="large-4 columns infopanel">
				<h4 id="gps">GPS:</h4>
			</div> 
		</div>
	</div> -->
<script type="text/javascript">// Google Maps code
	var directionsDisplay;
	var directionsService = new google.maps.DirectionsService();
	var map;
	function initializeMaps(latitude, longitude) {
		directionsDisplay = new google.maps.DirectionsRenderer();
		var options = {
			zoom: 10,
			center: new google.maps.LatLng(latitude, longitude),
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			mapTypeControl: true,
			mapTypeControlOptions: {
				style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
				position: google.maps.ControlPosition.TOP_RIGHT,
				mapTypeIds: [google.maps.MapTypeId.ROADMAP,
				google.maps.MapTypeId.TERRAIN,
				google.maps.MapTypeId.HYBRID,
				google.maps.MapTypeId.SATELLITE]
			},
			navigationControl: true,
			navigationControlOptions: {
				style: google.maps.NavigationControlStyle.ZOOM_PAN
			},
			scaleControl: true,
			disableDoubleClickZoom: true,
			draggable: true,
			streetViewControl: true,
			draggableCursor: 'move'
		};
		map = new google.maps.Map(document.getElementById("map_canvas"), options);
		directionsDisplay.setMap(map);
		calcRoute(latitude, longitude);
	}

	function calcRoute(latitude, longitude) {
		var start = new google.maps.LatLng(latitude, longitude);
		//end route on Car location
		var end = new google.maps.LatLng(18.2014,-67.1452);
		var request = {
			origin:start,
			destination:end,
			travelMode: google.maps.TravelMode.DRIVING
		};
		directionsService.route(request, function(result, status) {
			if (status == google.maps.DirectionsStatus.OK) {
				directionsDisplay.setDirections(result);
			}
		});
	}
</script>
<script type="text/javascript">
	var getTimes = function(date, success) {
		$.ajax({
			type: 'GET',
			url: 'times.php',
			data: {
				date: "'"+date+"'",
				car: <?php echo $carID; ?>
			},
			dataType: 'json',
			success: success
		});
	};
	
	var updateSelect = function(data) {
		$('#times').empty();
		//$('#pics').empty();
		$.each(data, function(index, value){
			$('#times').append('<option data-lat="'+ value.location.latitude +'" data-long="'+ value.location.longitude +'">' + value.time +'</option>');
			
			
			updateMap($('#times option:selected'));


			$('#times').change(function(e) {
				updateMap($(e.currentTarget));
				
				
			});

			
		});

		
		
		
	};
	
	var updateMap = function($el) {
		initializeMaps($el.data().lat, $el.data().long)
	};
	// var getPics = function(session, success) {
	// 		$.ajax({
	// 			type: 'GET',
	// 			url: 'pictures.php',
	// 			data: {
	// 				sessionID: "'"+session+"'"
	// 			},
	// 			dataType: 'json',
	// 			success: success
	// 		});
	// };

	// var updatePics = function(data) {
	// 	$('#pics').empty();
		
	// 	$.each(data, function(index, value){
	// 		$('#pics').append('<li><img src=' + value.path +'></li>');
			
		
	// 	});
	// };
	
	getTimes($('#dates option:selected').val(), updateSelect);
	//getPics($('#dates option:selected').val('sessionID'), updatePics);

	$('#dates').change(function(e) {
		getTimes($(e.currentTarget).val(), updateSelect);
		//getPics($(e.currentTarget).val(), updatePics);
		
	});


	

	// getPics($('#dates option:selected').val(), updatePics);

	// $('#dates').change(function(e) {
	// 	getPics($(e.currentTarget).val(), updatePics);
		
	// });






</script>
<script type="text/javascript">
	
	$(document).foundation();
</script>

</body>
</html>
