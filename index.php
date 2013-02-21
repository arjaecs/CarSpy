<?php  // This is the main page

// For handling the logout process
require_once('logoutHandler.php');
// For initializing the database
require_once('db.php');
// For checking if the user is logged in or returning
require_once('checkAuth.php');

$coordsID = $_GET['coordID'];
var_dump($coordsID);

//if (!isset($coordID)) {
  //  header('Location: index.php');
    //return;
//}

// Query to get the venue's info
//$db = db::getInstance();
//var_dump($db);
//$sql = "SELECT 
//             C.coordID, 
//             C.userID,
//             date_format(C.datetime, '%a., %b %D, %Y. %l: %i %p'),
//             C.GPS,  
//             C.street,
//             C.city, 
//             C.state, 
//             C.zipcode
//         FROM Coords C
//         WHERE C.coordID = {$coordsID};
// ";


// $stmt = $db->prepare($sql);
// $stmt->execute();

// $result = $stmt->fetchAll();


// $coords = $result[0];

?>
<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8" />

	<!-- Set the viewport width to device width for mobile -->
	<meta name="viewport" content="width=device-width" />

	<title>CarSpy</title>

	<!-- Included CSS Files -->
	<link rel="stylesheet" href="stylesheets/foundation.css">
	<!-- <link rel="stylesheet" href="stylesheets/compass.css"> -->
	<link rel="stylesheet" href="stylesheets/app.css">
	

	<!--[if lt IE 9]>
		<link rel="stylesheet" href="stylesheets/ie.css">
	<![endif]-->

	<script src="javascripts/modernizr.foundation.js"></script>

	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

</head>
<body>

	<!-- container 
	<div class="container"> -->
	<div class='home'>	

		<div class="row">
			<div class="twelve columns">
				<h2>CarSpy</h2>
				
				<hr />
			</div>
		</div>

		<div class="row">
			<div class="twelve columns">
				<h3>The Grid</h3>

				<div class='overview'>
				<!-- Grid Example -->
				<div class="row">
					<div class="twelve columns">
						<div id='map' style="height: 500px; width: 100%"/>
					</div>
				</div>
				<div class="row">
					<div class="six columns">
						<div class="panel">
							<p>Six columns</p>
						</div>
					</div>
					<div class="six columns">
						<div class="panel">
							<p>Six columns</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="four columns">
						<div class="panel">
							<p>Four columns</p>
						</div>
					</div>
					<div class="four columns">
						<div class="panel">
							<p>Four columns</p>
						</div>
					</div>
					<div class="four columns">
						<div class="panel">
							<p>Four columns</p>
						</div>
					</div>
				</div>
			</div>

				<h3>Tabs</h3>
				<dl class="tabs">
					<dd><a href="#simple1" class="active">Simple Tab 1</a></dd>
					<dd><a href="#simple2">Simple Tab 2</a></dd>
					<dd><a href="#simple3">Simple Tab 3</a></dd>
				</dl>

				<ul class="tabs-content">
					<li class="active" id="simple1Tab">This is simple tab 1's content. Pretty neat, huh?</li>
					<li id="simple2Tab">This is simple tab 2's content. Now you see it!</li>
					<li id="simple3Tab">This is simple tab 3's content. It's, you know...okay.</li>
				</ul>

				<h3>Buttons</h3>

				<div class="row">
					<div class="six columns">
						<p><a href="#" class="small blue button">Small Blue Button</a></p>
						<p><a href="#" class="blue button">Medium Blue Button</a></p>
						<p><a href="#" class="large blue button">Large Blue Button</a></p>

						<p><a href="#" class="nice radius small blue button">Nice Blue Button</a></p>
						<p><a href="#" class="nice radius blue button">Nice Blue Button</a></p>
						<p><a href="#" class="nice radius large blue button">Nice Blue Button</a></p>
					</div>
					<div class="six columns">
						<p><a href="#" class="small red button">Small Red Button</a></p>
						<p><a href="#" class="green button">Medium Green Button</a></p>
						<p><a href="#" class="large white button">Large White Button</a></p>

						<p><a href="#" class="nice radius small red button">Nice Red Button</a></p>
						<p><a href="#" class="nice radius green button">Nice Green Button</a></p>
						<p><a href="#" class="nice radius large white button">Nice White Button</a></p>
					</div>
				</div>
			</div>

			
		</div>

	</div>
	<!-- container -->

	<!-- Included JS Files -->
	<script src="javascripts/jquery.min.js"></script>
	<script src="javascripts/jquery.reveal.js"></script>
	<script src="javascripts/jquery.orbit-1.4.0.js"></script>
	<script src="javascripts/jquery.customforms.js"></script>
	<script src="javascripts/jquery.placeholder.min.js"></script>
	<script src="javascripts/jquery.tooltips.js"></script>
	<script src="javascripts/app.js"></script>
	
	<script type="text/javascript" language="JavaScript" src="http://j.maxmind.com/app/geoip.js"></script>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript">
	        var directionsDisplay;
	        var directionsService = new google.maps.DirectionsService();
	        var map;
	        function initialize() {
	            directionsDisplay = new google.maps.DirectionsRenderer();

	            var options =
	            {
	                zoom: 10,
	                center: new google.maps.LatLng(geoip_latitude(), geoip_longitude()),
	                mapTypeId: google.maps.MapTypeId.ROADMAP,
	                mapTypeControl: true,
	                mapTypeControlOptions:
	                {
	                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
	                    position: google.maps.ControlPosition.TOP_RIGHT,
	                    mapTypeIds: [google.maps.MapTypeId.ROADMAP,
	                        google.maps.MapTypeId.TERRAIN,
	                        google.maps.MapTypeId.HYBRID,
	                        google.maps.MapTypeId.SATELLITE]
	                },
	                navigationControl: true,
	                navigationControlOptions:
	                {
	                    style: google.maps.NavigationControlStyle.ZOOM_PAN
	                },
	                scaleControl: true,
	                disableDoubleClickZoom: true,
	                draggable: false,
	                streetViewControl: true,
	                draggableCursor: 'move'
	            };
	            map = new google.maps.Map(document.getElementById("map"), options);
	            directionsDisplay.setMap(map);
	            // Add Marker and Listener
	            var latlng = new google.maps.LatLng(geoip_latitude(), geoip_longitude());
	            calcRoute();

	        }

	        function calcRoute() {
	            var start = new google.maps.LatLng(geoip_latitude(), geoip_longitude());
	            var end = new google.maps.LatLng(<?php echo $coords['GPS'] ?>);
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
	        window.onload = initialize;
	    </script>

</body>
</html>
