<?php

require_once('db.php');
require_once('checkAuth.php');
require_once('logout.php');

// Checks if user is logged in, otherwise returns to login.php
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


	$cars = array();
	for ($i = 0; $i < count($vehicles); $i++){
	 
	 // add each date to the end of the times array
	 $cars[] = array(
	 	'vehicleID' => $vehicles[$i]['vehicleID'], 
	 	'make' => $vehicles[$i]['make'], 
	 	'model' => $vehicles[$i]['model'],
	 	'licensePlate' => $vehicles[$i]['licensePlate'] 	
	 	);

	}
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
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

	<script type="text/javascript">
		window.cars = <?php echo json_encode($cars); ?>;
	</script>

</head>
<body>

	<div id="topnav">
		 <div id="cslogo">
		 	<a href="/"><img  src="img/CarSpyGray2.png"></a>
		 </div>
		 <div class="small-6 columns">
			<span>
				<h3 >Welcome, <a href="profile.php" style="color: #ff7b0d;"><?php echo $user['firstName'] ?> <?php echo $user['lastName'] ?></a></h3>
				
			</span>
			<span style="float: right; margin-top: -20px; margin-right: 50px;">
				
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" >
                <input type="hidden" value="logout" name="loggedOut" />
                <input type="hidden" style="color: #32CD32; text-decoration: underline;" value="Log Out" />
                <a href="#" onclick="this.parentNode.submit()" style="text-align: right; size: 6px; color: gray; ">Log Out</a>
            </form>

			</span>
		
		</div> 

	</div>
	
	<div class="row container dynamo">
		<div class="large-3 selects" >

			<div style="text-align:center;">
					<h5>Choose a Car:</h5> 
					<select id="car" name='car' class="form-select">
				 	<?php
					 	for ($i = 0; $i<count($cars); $i++){
							// add each date to the end of the times array
							echo "<option value='{$cars[$i]['vehicleID']}'>{$cars[$i]['make']} {$cars[$i]['model']}</option>";
						}
					?>
					</select>
					<h5>Choose a Date:</h5> 
					<select id="dates" name='date' class="form-select"></select>
					<h5>Choose a Time:</h5> 
					<select id="times" name="time" class='form-select'>
							
					</select>			
			</div>
		</div>
		<div class="large-9 theMap columns">
			<div style="height:300px;  ">
				<div id="map_canvas"></div>
			</div>
		</div>
	</div>

	<div class="row container">
		<div class="large-12 panel" style="width:102%; margin-top:-5px; margin-left:-10px; margin-right:-10px;">
			<div class="ribbon-before"></div>
			<div class="ribbon-after"></div>
			
			<h3>Pictures:</h3>
		</div>
	</div>

	<div class="row container">
		
 		<div class="large-12" >

 			<ul id="pics">

			</ul>

 		</div>


	</div>
	<div class="footer" style="height: 200px; width: 100%;margin-bottom:0px; background-color: #2f2f2f;padding-left:40%;">
		<img style="margin-top: 4%;height: 70%;" src="img/VigilanTECH2gray.png">
	</div>

<script>
		var drawMap = function(latitude, longitude) {
			var coords = new google.maps.LatLng(latitude, longitude);
			var options = {
				zoom: 15,
				center: coords,
				mapTypeControl: false,
				navigationControlOptions: {
					style: google.maps.NavigationControlStyle.SMALL
				},
				mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		var map = new google.maps.Map(document.getElementById("map_canvas"), options);
		var geocoder = new google.maps.Geocoder();
		var infowindow = new google.maps.InfoWindow();

		// Map marker label content
		var contentString = function(address,coords) {

			var where = '<div id="infoBOX">'+
			    '<div id="siteNotice">'+
			    '</div>'+
			    '<h4 id="firstHeading" class="firstHeading" style="text-align:center;">CarSpy Location</h4>'+
			    '<div id="bodyContent">'+
			    '<a src="http://maps.google.com/?q='+coords+'">'+address+'</a>'+

			    '</div>'+
			    '</div>';

    	return where;}



    	// Maps' reverse GeoCoder for human-readable directions to given the coordinates
		geocoder.geocode({'latLng': coords}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[1]) {
					map.setZoom(11);
					marker = new google.maps.Marker({
						position: coords,
						map: map
					});
					//infowindow.setContent(results[1].formatted_address);
					infowindow.setContent(contentString(results[1].formatted_address,coords));
					infowindow.open(map, marker);
				}
			} else {
				alert("Geocoder failed due to: " + status);
			}
		});
	};

	var updateMap = function($el) {
		drawMap($el.data().latitude, $el.data().longitude);
	};

	// Dates - calls times when finished

	var getDates = function(car, success) {
		$.ajax({
			type: 'GET',
			url: 'dates.php',
			data: {
				vehicleID: car				
			},
			dataType: 'json',
			success: success
		});
	};
	
	var updateDates = function(data) {
		$.each(data, function(index, value){
			$('#dates').append('<option value="'+ value.date +'">' + value.day +'</option>');
		});

		getTimes($('#car option:selected').val(), $('#dates option:selected').val(), updateTimes);
	};

	// Times - calls pictures when finished

	var getTimes = function(car, date, success) {
		$.ajax({
			type: 'GET',
			url: 'times.php',
			data: {
				date: "'"+date+"'",
				car: car
			},
			dataType: 'json',
			success: success
		});
	};

	var updateTimes = function(data) {
		$.each(data, function(index, value){
			$('#times').append('<option data-latitude="'+ value.location.latitude +'" data-longitude="'+ value.location.longitude +'" data-session="'+ value.session +'">' + value.time +'</option>');
		});

		updateMap($('#times option:selected'));

		getPictures($('#times option:selected').data().session, updatePictures);
	};
	
	// Pictures - end of the road

	var getPictures = function(sessionID, success) {
		$.ajax({
			type: 'GET',
			url: 'pictures.php',
			data: {
				sessionID: sessionID
			},
			dataType: 'json',
			success: success
		});
	};

	var updatePictures = function(data) {
		$.each(data, function(index, value){
			$('#pics').append('<li><img src="' + value.path +'"></li>');
		});
	};

	//Setup event listeners
	
	$('#car').change(function(e) {
		$('#dates, #times, #pics').empty();
		getDates($(e.currentTarget).val(), updateDates);		
	});

	$('#times').change(function(e) {
		$('#pics').empty();
		var $el = $('#times option:selected');
		updateMap($el);
		getPictures($el.data().session, updatePictures);
	});

	$('#dates').change(function(e) {
		$('#times, #pics').empty();
		getTimes($('#car option:selected').val(), $(e.currentTarget).val(), updateTimes);		
	});

	//Kick it off

	getDates($('#car option:selected').val(), updateDates);

	$(document).foundation();
</script>
</body>
</html>