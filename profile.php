<?php  // This page displays the user's profile
require_once('db.php');
require_once('checkAuth.php');
require_once('logout.php');

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

    if(count($vehicles)>1){
    	$manyCars = true;
    	$car2 = $vehicles[1];
    }

    

    //var_dump($vehicles['make']);

if(!isset($vehicles)){
    header('Location: login.php');
    return;
}

if (count($_POST) > 0) {

	$db = db::getInstance();

	if($_POST['submit'] == 'edit'){
	    

		$sql = "UPDATE User
	            SET
	                firstName = '{$_POST['firstName']}',
	                lastName = '{$_POST['lastName']}',
	                email = '{$_POST['email']}',
	                birth = '{$_POST['birth']}',
	                gender = '{$_POST['gender']}',
	                phone = '{$_POST['phone']}',
	                address = '{$_POST['address']}'
	            WHERE userID = '{$id}'
	    ";

	    $stmt = $db->prepare($sql);
	    $stmt->execute();

	    }
	else{

		$sql = "UPDATE Vehicle
	            SET
	                
                userID = '{$id}',
                make = '{$_POST['make']}',
                model = '{$_POST['model']}',
                color = '{$_POST['color']}',
                year = '{$_POST['year']}',
                licensePlate = '{$_POST['licensePlate']}',
                owner = '{$_POST['owner']}'
                
                WHERE vehicleID = '{$_POST['vehicleID']}';";

	    $stmt = $db->prepare($sql);
	    $stmt->execute();


	
		
	}
	
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
				<h3 >Welcome, <a class="dropdown-toggle" role="button" data-toggle="dropdown" data-target="" href="profile.php" id="username"><?php echo $user['firstName'] ?> <?php echo $user['lastName'] ?></a></h3>
				
			</span>
			<span style="float: right; margin-right: 50px; margin-top: -20px;">
				<!-- <a href="#" onclick="this.parentNode.submit()"><p style="text-align: right; size: 6px; color: gray; margin-right: 50px; margin-top: -20px;">Log Out</p>


			</a>
 -->
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
							      <li class="active"><a href="#edit" data-toggle="modal" data-target="#edit">Edit</a></li>
							      <li class="divider"></li>
							      
							  </ul>
						  </section>
						</nav>
			    		<table class="responsive">
							
							
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
                              <h1><a href="#">Device ID</a></h1>
                            </li>
                            <li class="divider"></li>
                            <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone 
                            <li class="toggle-topbar menu-icon"><a href="#"><span>INFO</span></a></li>-->
                          </ul>

                          <section class="top-bar-section">
                                
                                <ul class="left">
                                  <li class="divider"></li>
                                  <li class="active"><a href="#"><?php echo $car['vehicleID'] ?></a></li>
                                  <li class="divider"></li>
                                  

                                
                                    <?php
                                        if($manyCars){
                                            echo "<li><a href='#'>{$car2['vehicleID']}</a></li>
                                  <li class='divider'></li>";}
                                        
                                        ?>

                              </ul>
                            
                              <ul class="right">
                                  <li class="divider"></li>
                                  <li class="active"><a href="#add" data-toggle="modal" data-target="#add">Add/Edit</a></li>
                                  <li class="divider"></li>
                                  
                              </ul>
                          </section>
                        </nav>
                        <table>
                            
                            
                            <colgroup title="title" />
                            
                            <tbody>
                                <tr>
                                    <td>Make</td>
                                    <td><?php echo $car['make'];?></td>
                                    <?php
                                        if($manyCars){
                                            echo "<td>{$car2['make']}</td>";}
                                        
                                        ?>
                                    
                                </tr>
                                <tr>
                                    <td>Model</td>
                                    <td><?php echo $car['model'];?></td>
                                    <?php
                                        if($manyCars){
                                            echo "<td>{$car2['model']}</td>";}
                                        
                                        ?>
                                </tr>
                                <tr>
                                    <td>Color</td>
                                    <td><?php echo $car['color'];?></td>
                                    <?php
                                        if($manyCars){
                                            echo "<td>{$car2['color']}</td>";}
                                        
                                        ?>
                                </tr>
                                <tr>
                                    <td>Year</td>
                                    <td><?php echo $car['year'];?></td>
                                    <?php
                                        if($manyCars){
                                            echo "<td>{$car2['year']}</td>";}
                                        
                                        ?>
                                    
                                </tr>
                                <tr>
                                    <td>License Plate</td>
                                    <td><?php echo $car['licensePlate'];?></td>
                                    <?php
                                        if($manyCars){
                                            echo "<td>{$car2['licensePlate']}</td>";}
                                        
                                        ?>
                                    
                                </tr>
                                <tr>
                                    <td>Owner</td>
                                    <td><?php echo $car['owner'];?></td>
                                    <?php
                                        if($manyCars){
                                            echo "<td>{$car2['owner']}</td>";}
                                        
                                        ?>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>

					
		    	</div> 
			    
		    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="editProfile">
		    	<div id="edit" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="editProfile" aria-hidden="true">
						 <div class="modal-header">
						    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						    <h3 id="editProfile">Edit Profile Info</h3>
						  </div>

						  <div class="modal-body">
						    
						    <div class="control-group">
							    <label class="control-label" for="firstName">First Name</label>
							    <div class="controls">
							      <input type="text" id="firstName" name="firstName" value="<?php echo $user['firstName'] ?>" required="required">
							    </div>
							  </div>
							  <div class="control-group">
							    <label class="control-label" for="lastName">Last Name</label>
							    <div class="controls">
							      <input type="text" id="lastName" name="lastName" value="<?php echo $user['lastName'] ?>" required="required">
							    </div>
							  </div>	
							  <div class="control-group">
							    <label class="control-label" for="email">Email</label>
							    <div class="controls">
							      <input id="email" name="email" type="email" value="<?php echo $user['email'] ?>" required="required">
							      
							  	</div>
								</div>

							  <!-- add button to email password change instead -->
							  <div class="control-group">
							    <label class="control-label" for="password">Password</label>
							    <div class="controls">
							      <input type="password" id="password" name="password" placeholder="Password" required="required">
							    </div>
							  </div>

							  <div class="control-group">
							    <label class="control-label" for="gender">Gender</label>
							    <div class="controls">
							    	<select name="gender" id="gender" name="gender">
                                        <option value='Male'>Male</option>
                                        <option value='Female'>Female</option>
                                    </select>
							    </div>
							  </div>
							  <div class="control-group">
							    <label class="control-label" for="phone">Phone</label>
							    <div class="controls">
							      <input type="tel" id="phone" name="phone" value="<?php echo $user['phone'] ?>">
							    </div>
							  </div>
							  <div class="control-group">
							    <label class="control-label" for="date">Date of Birth</label>
							    <div class="controls">
							      <input type="text" id="date" name="date" value="<?php echo $user['birth'] ?>"/>
							    </div>
							  </div>
							  <div class="control-group">
							    <label class="control-label" for="address">Address</label>
							    <div class="controls">
							      <input type="text" id="address" name="address" value="<?php echo $user['address'] ?>">
							    </div>
							  </div>
						  </div>
						  <div class="modal-footer">
						    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
						    <button type='submit' name="submit" value="edit" class="btn btn-warning btn-primary">Confirm</button>
						  </div>
					</div>
				</form>
				<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="addCar">
					<div id="add" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="addCar" aria-hidden="true">
						 <div class="modal-header">
						    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						    <h3 id="addCar">Add a Device</h3>
						  </div>

						  <div class="modal-body">
						    
						    <div class="control-group">
							    <label class="control-label" for="vehicleID">Device ID</label>
							    <div class="controls">
							      <input type="text" id="vehicleID" name="vehicleID" placeholder="Device ID" required="required">
							    </div>
							  </div>
							  <div class="control-group">
							    <label class="control-label" for="make">Make</label>
							    <div class="controls">
							      <input type="text" id="make" name="make" placeholder="Toyota" required="required">
							    </div>
							  </div>	
							  <div class="control-group">
							    <label class="control-label" for="model">Model</label>
							    <div class="controls">
							      <input id="Model" name="Model" type="text" placeholder="Prius" required="required">
							      
							  	</div>
								</div>

							  <!-- add button to email password change instead -->
							  <div class="control-group">
							    <label class="control-label" for="color">Color</label>
							    <div class="controls">
							      <input type="text" id="color" name="color" placeholder="Green" required="required">
							    </div>
							  </div>

							  <div class="control-group">
							    <label class="control-label" for="year">Year</label>
							    <div class="controls">
							    	<input type="text" id="year" name="year" placeholder="2005" required="required">
							    </div>
							  </div>
							  <div class="control-group">
							    <label class="control-label" for="licensePlate">License</label>
							    <div class="controls">
							      <input type="text" id="licensePlate" name="licensePlate" placeholder="SPR-ING">
							    </div>
							  </div>
							  <div class="control-group">
							    <label class="control-label" for="owner">Owner</label>
							    <div class="controls">
							      <input type="text" id="owner" name="owner" placeholder="Juan del Campo"/>
							    </div>
							  </div>
							  
						  </div>
						  <div class="modal-footer">
						    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
						    <button type='submit' name="submit" value="add" class="btn btn-warning btn-primary">Add Device</button>
						  </div>
					</div>


				</form>
		    </div>

	</div>

	 <!-- /container --> 


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
	
	<script src="js/foundation/foundation.topbar.js"></script>

	-->

	<script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

	

	
  
  <script>
    $(document).foundation();
  </script>
</body>
</html>
