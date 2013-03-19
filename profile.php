<?php  // This page displays the user's profile
require_once('db.php');
require_once('checkAuth.php');
//require_once('logout.php');

//$userID = $_GET['userID'];
//var_dump($id);
// Checks if user is logged in, otherwise returns index
if (!$loggedin && !isset($id)) {
    header('Location: login.php');
    return;
}

//$friendProfile = false;

	$db = db::getInstance();


    // Query to get the user's info if it's his/her own profile
    $sql = "SELECT
    			userID,
                password,
                    firstName,
                    lastName,
                    email,
                    phone,
                    birth,
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




?>

<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
	<meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title>CarSpy</title>

    <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link rel="stylesheet" href="css/normalize.css" />
  
  <link rel="stylesheet" href="css/profile.css" />
  

  <script src="js/vendor/custom.modernizr.js"></script>

</head>
<body>

	<div id="topnav">
		 <div id="cslogo">
		 	<a href="/"><img  src="img/CarSpyGray2.png"></a>
			<span>
				<h3 style="margin-top:-45px; margin-right:50px; ">Welcome, <a href="/"><?php echo $user['firstName'] ?> <?php echo $user['lastName'] ?></a></h3>
				
			</span>
		</div>
		
		
		    
		    
		    
		   
		 

	</div>
	<div class="row">
		<div class="large-12 columns container">
		    	
		    	<div class="panel">
		    		<div id="personal">
		    			<!-- TO CONSIDER!

		    			<div class="section-container" data-section>
							  <section class="section">
							    <p class="title"><a href="#panel1">Section 1</a></p>
							    <div class="content">
							      <p>Content of section 1.</p>
							    </div>
							  </section>
							  <section class="section">
							    <p class="title"><a href="#panel2">Section 2</a></p>
							    <div class="content">
							      <p>Content of section 2.</p>
							    </div>
							  </section>
							</div>
						-->
		    			<nav class="top-bar">
						  <ul class="title-area">
						    <!-- Title Area -->
						    <li class="name">
						      <h1><a href="#">Personal Info</a></h1>
						    </li>
						    <li class="divider"></li>
						    <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone  
						    <li class="toggle-topbar menu-icon"><a href="#"><span>INFO</span></a></li>-->
						  </ul>

						  <section class="top-bar-section">
						  		<ul class="right">
							      <li class="divider"></li>
							      <li class="active"><a href="#">Edit</a></li>
							      <li class="divider"></li>
							      
							  </ul>
						  </section>
						</nav>
			    		<table>
							
							
							<colgroup title="title" />
							
							<tbody>
								<tr>
									<td>Name</td>
									<td><?php echo $user['firstName'] ?> <?php echo $user['lastName'] ?></td>
									
								</tr>
								<tr>
									<td>Gender</td>
									<td><?php echo $user['gender'] ?></td>
									
								</tr>
								<tr>
									<td>Date of Birth</td>
									<td><?php echo $user['birth'] ?></td>
									
								</tr>
								<tr>
									<td>Email</td>
									<td><?php echo $user['email'] ?></td>
									
								</tr>
								<tr>
									<td>Phone</td>
									<td><?php echo $user['phone'] ?></td>
									
								</tr>
								<tr>
									<td>Address</td>
									<td><?php echo $user['address'] ?></td>
									
								</tr>
								
							</tbody>
						</table>
					</div>

					<div id="vehicle">
						<nav class="top-bar">
						  <ul class="title-area">
						    <!-- Title Area -->
						    <li class="name">
						      <h1><a href="#">Vehicle Info</a></h1>
						    </li>
						    <li class="divider"></li>
						    <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone 
						    <li class="toggle-topbar menu-icon"><a href="#"><span>INFO</span></a></li>-->
						  </ul>

						  <section class="top-bar-section">
						  		<ul class="left">
							      <li class="divider"></li>
							      <li class="active"><a href="#">LIC-ENS</a></li>
							      <li class="divider"></li>
							      <li><a href="#">EPL-ATE</a></li>
							      <li class="divider"></li>
							  </ul>
							  <ul class="right">
							      <li class="divider"></li>
							      <li class="active"><a href="#">Edit</a></li>
							      <li class="divider"></li>
							      
							  </ul>
						  </section>
						</nav>
			    		<table>
							
							
							<colgroup title="title" />
							
							<tbody>
								<tr>
									<td>Make</td>
									<td>Cadillac</td>
									
								</tr>
								<tr>
									<td>Model</td>
									<td>El Dorado</td>
									
								</tr>
								<tr>
									<td>Color</td>
									<td>Red</td>
									
								</tr>
								<tr>
									<td>Year</td>
									<td>1973</td>
									
								</tr>
								<tr>
									<td>License</td>
									<td>SGR DDY</td>
									
								</tr>
								<tr>
									<td>Owner</td>
									<td><?php echo $user['firstName'] ?> <?php echo $user['lastName'] ?></td>
									
								</tr>
							</tbody>
						</table>
					</div>

					
		    	</div> 
			    

		    </div>

	</div>

	 <!-- /container --> 


  <script>
  document.write('<script src=' +
  ('__proto__' in {} ? 'js/vendor/zepto' : 'js/vendor/jquery') +
  '.js><\/script>')
  </script>

  <!-- <script type="text/javascript">

        var type = [];
        type["blank"] = [""];
        type["Concert"] = ["Alternative", "Rock","Pop", "Hip Hop / Rap","Electronic", "Country", "Classical"];
        type["Sports"] = ["Basketball","Baseball","Soccer","Volleyball","Tennis","Boxing","Swimming","Cycling"];
        type["Entertainment"] = ["Culinary","Cinema","Arts","Theater","Comedy","Politics"];
        type["Business"] = ["Conferences","Meetings","Seminars","JobFairs","Sales"];

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

    </script> -->
  
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
	
	<script src="js/foundation/foundation.topbar.js"></script>

	-->

	<script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

	

	
  
  <script>
    $(document).foundation();
  </script>
</body>
</html>
