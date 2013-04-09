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
	
	<!--
	
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBYeihJGidZ-x1D2gtw7gy02hC-gNDdW2U&sensor=true"></script>
	<script type="text/javascript" language="JavaScript" src="http://j.maxmind.com/app/geoip.js"></script>-->
	
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>

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
					<select id="dates" name='date' class="form-select">
					 	<?php
					 	for ($i = 0; $i<count($dates); $i++){
 
						 // add each date to the end of the times array
						 echo "<option value='{$dates[$i]['date']}'>{$dates[$i]['day']}</option>";
						}
						?>
					</select>
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
		
 		<div class="large-12">

 			<ul id="pics">

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


<script>
function initializeMaps(position) {
  
  var coords = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
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
  var marker = new google.maps.Marker({
      position: coords,
      map: map,
      title:"You are here!"
  });
}
if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(initializeMaps);
} else {
  error('Geo Location is not supported');
}
</script>

<script>
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
		$('#pics').empty();
		$.each(data, function(index, value){
			console.log("Session ID ="+value);
			$('#times').append('<option data-latitude="'+ value.location.latitude +'" data-longitude="'+ value.location.longitude +'" data-session="'+ value.sessionID +'">' + value.time +'</option>');
			
			 $('#pics').append('<li><img src="' + value.path1 +'"></li>');

			$('#pics').append('<li><img src=' + value.path2 +'></li>');
			$('#pics').append('<li><img src=' + value.path3 +'></li>');
	
			
			updateMap($('#times option:selected'));
			//updatePics($('#times option:selected'));


			$('#times').change(function(e) {
				//console.log(e.currentTarget);
				updateMap($(e.currentTarget));
				//updatePics($(e.currentTarget));
				
				
			});

			
		});

		
		
		
	};
	
	var updateMap = function($el) {
		//initializeMaps($el.data().lat, $el.data().long);
		initializeMaps($el.data());
		//updatePics($el.data().session);
	};

	// var getPics = function(sessionID, success) {
	// 		console.log(sessionID);
	// 		$.ajax({
	// 			type: 'GET',
	// 			url: 'pictures.php',

	// 			data: {
	// 				sessionID: "'"+sessionID+"'"
	// 			},
	// 			dataType: 'json',
	// 			success: success
	// 		});
	// };

	// var updatePics = function(data) {
	// 	$('#pics').empty();
		
	// 	$.each(data, function(index, value){
		
	// 		$('#pics').append('<li><img src="' + value.path +'"></li>');

	// 		//$('#pics').append('<li><img src=' + $el.data().path2 +'></li>');
	// 		//$('#pics').append('<li><img src=' + $el.data().path3 +'></li>');
	// 	});
		
		
	// };
	
	getTimes($('#dates option:selected').val(),updateSelect);
	//getPics($('#times option:selected').val(), updatePics);

	$('#dates').change(function(e) {
		getTimes($(e.currentTarget).val(),updateSelect);
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
