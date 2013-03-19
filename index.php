<?php // Page for logging in and for registering if you are a new user.
require_once('db.php');

// Checks if the user is logged in and redirects to index
if(isset($_COOKIE['loggedin'])){
    $loggedin = true;
    header('Location: home.php');
    return;
}
else {
	header('Location: login.php');
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

</head>
<body onload="initialize()">

	<div id="topnav">
		 <div id="cslogo"><a href="/"><img  src="img/CarSpyGray2.png"></a>
<span><a href="/"><h3 style="margin-top:-45px; margin-right:50px; font-style:italic;">username</h3></a></span>
				   </div>
		
		
		    
		    
		    
		   
		 

	</div>
	
	<div class="row">
		<div class="large-12 columns container">
			

					<h3 align="center">Choose An Event:</h3>
					
					
					<form>
			
					<span style="text-align:center; margin-left: 10%; ">
					<select name="make" style="width:40%;">
						<option>March 6, 2013</option>
						  <option>2</option>
						  <option>3</option>
						  <option>4</option>
						  <option>5</option>
					</select>
					
					<select name="type" style="width:40%">
						<option>12:45 P.M.</option>
						  <option>2</option>
						  <option>3</option>
						  <option>4</option>
						  <option>5</option>
					</select>
					
					
					</form>
					</span>
				
		</div>
	</div> 

	<div class="row container">
		<div class="large-12  mapcase">
			
				<div id="map_canvas"></div>
			
		</div>
		<div class="large-12 panel" style="width:1020px; margin-top:-5px; margin-left:-10px; margin-right:-10px;">
			<div class="ribbon-before"></div>
			<div class="ribbon-after"></div>
			
			<h3>Pictures:</h3>
		</div>
	</div>

	<div class="row container">
		<div class="large-12 accordian" >
				<ul>
					<li>
						<div class="image_title">
							<a href="#">Spy Pic 1</a>
						</div>
						<a href="#">
							<img src="img/CarSpy2.jpg"/>
						</a>
					</li>
					<li>
						<div class="image_title">
							<a href="#">Spy Pic 2</a>
						</div>
						<a href="#">
							<img src="img/CarSpy2.jpg"/>
						</a>
					</li>
					<li>
						<div class="image_title">
							<a href="#">Spy Pic 3</a>
						</div>
						<a href="#">
							<img src="img/CarSpy2.jpg"/>
						</a>
					</li>
					
				</ul>
		</div>
		<div class="large-12 panel" style="width:1020px; margin-top:-5px; margin-left:-10px; margin-right:-10px;">
			<div class="ribbon-before"></div>
			<div class="ribbon-after"></div>
			
			<h3>Event Info:</h3>
		</div>

	</div>
	<div class="row container">
		<div class="large-12" >
		
			<div class="large-4 columns infopanel" >
				<h4>Date:</h4>
				
			</div> 
			<div class="large-4 columns infopanel">
				<h4>Time:</h4>
			</div> 
			<div class="large-4 columns infopanel">
				<h4>GPS:</h4>
			</div> 
		</div>
	</div>
		




			


  <script>
  document.write('<script src=' +
  ('__proto__' in {} ? 'js/vendor/zepto' : 'js/vendor/jquery') +
  '.js><\/script>')
  </script>
  
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

	<script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBYeihJGidZ-x1D2gtw7gy02hC-gNDdW2U&sensor=false">
    </script>

    <script type="text/javascript">
     function initialize() {
        var mapOptions = {
          center: new google.maps.LatLng(18.201422, -67.145157),
          zoom: 12,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };



        var map = new google.maps.Map(document.getElementById("map_canvas"),
            mapOptions);
      }
      </script>

    <!--
    <script src="js/maps.js"></script>

    <script type="text/javascript"> 
    
    if (GBrowserIsCompatible()) { 
 
  
      function createMarker(point,html) {
        var marker = new GMarker(point);
        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(html);
        });
        return marker;
      }
 
      // Display the map, with some controls and set the initial location 

	  var mapOptions = {  }

	  map = new GMap2(document.getElementById("map"), mapOptions);
	  map.setCenter(new GLatLng(33.956461,-118.396225), 13);
	  map.setUIToDefault();


      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng(18.201422, -67.145157),13);
    
      // Set up three markers with info windows 
    
      var point = new GLatLng(18.201422, -67.145157);
	//<![CDATA[
      var marker = createMarker(point,'<div style="width:240px"><br />18.201422, -67.145157</div>')
	//]]>

      map.addOverlay(marker);

 
    }
    
    // display a warning if the browser was not compatible
    else {
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }
 
    </script>
 -->  

	
  
  <script>
    $(document).foundation();
  </script>
</body>
</html>
