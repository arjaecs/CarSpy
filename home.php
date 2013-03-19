
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
		<div class="row">
		    
		    <div class="large-8 columns"><a href="/"><h1>CarSpy</h1></a></div>
		    <div class="large-4 columns"><a href="/"><h3>username</h3></a></div>
		    
		   
		</div>  
	</div>
	
	<div class="row">
		<div class="large-12 columns container">
			

					<h3 align="center">Choose An Event:</h3>
					
					
					<form>
			
					<span style="text-align:center; margin-left: 10%; ">
					
					

					<select name='make' style="width:40%" class="form-select"  onchange="fillSelect(this.value,this.form['type'])">
	                  <option value='blank'>Select Date</option>
	                  <option value='LastDay'>subForLastDay</option>
	                  <option value='Day1'>Day1</option>
	                  <option value='Day2'>Day2</option>
	                  <option value='Day3'>Day3</option>
            
					</select>
					<select name="type" style="width:40%">
						<option value="">Select Session</option>	
					</select>
					
					
						</form>
					</span>
		</div>
	</div> 

	<div class="row container">
		<div class="large-12">
			<div style="height:300px; padding:5px; ">
				<div id="map_canvas"></div>
			</div>
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
  
  	<script src="js/foundation/foundation.js"></script> <!--
	
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
    <script type="text/javascript">

    </script>

	<script type="text/javascript">

        var type = [];
        type["blank"] = [""];
        type["LastDay"] = ["Alternative", "Rock","Pop", "Hip Hop / Rap","Electronic", "Country", "Classical"];
        type["Day1"] = ["Basketball","Baseball","Soccer","Volleyball","Tennis","Boxing","Swimming","Cycling"];
        type["Day2"] = ["Culinary","Cinema","Arts","Theater","Comedy","Politics"];
        type["Day3"] = ["Conferences","Meetings","Seminars","JobFairs","Sales"];

        function fillSelect(nValue,nList){

            nList.options.length = 1;
            var curr = type[nValue];
            for (each in curr)
            {
                var nOption = document.createElement('option');
                nOption.appendChild(document.createTextNode(curr[each]));
                nOption.setAttribute("value",curr[each]);
                nList.appendChild(nOption);
            }
        }

    </script>
  
  <script>
    $(document).foundation();
  </script>
</body>
</html>
