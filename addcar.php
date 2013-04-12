<?php // Page for logging in and for registering if you are a new user.
require_once('db.php');
require_once('checkAuth.php');
require_once('logout.php');

if (!$loggedin && !isset($id)) {
    header('Location: login.php');
    return;
}
//var_dump($id);

$newcar = false;

$db = db::getInstance();

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

if ( count($_POST) > 0) {



		$notfound = false;
		$car = array('car' => $_POST['vehicleID']);

		$sql = "SELECT userID, make, model, licensePlate FROM Vehicle WHERE vehicleID = :car;";

		
	    $stmt = $db->prepare($sql);

	    $stmt->execute($car);
	    $result = $stmt->fetchAll();

	    var_dump($result[0]['userID']);
	    if (count($result)>0 && $result[0]['userID']==1) {
	    	
	    	
		$data = array(

        	'vehicleID' => $_POST['vehicleID'],
            'userID' => $id,
            'make' => $_POST['make'],
            'model' => $_POST['model'],
            'color' => $_POST['color'],
            'year' => $_POST['year'],
            'licensePlate' =>  $_POST['licensePlate'],
            'owner' => $_POST['owner']


        	);


		$carsql = "UPDATE Vehicle
	            SET
	                
                userID = :userID,
                make = :make,
                model = :model,
                color = :color,
                year = :year,
                licensePlate = :licensePlate,
                owner = :owner
                
                WHERE vehicleID = :vehicleID;";

	    $stmt = $db->prepare($carsql);
	    $stmt->execute($data);
	    $lastID=$db->lastInsertId();
	    $newcar = true;
		//global $id;

		}
		else{
		$notfound = true;
		}
	
	



}
if($newcar) { 
	//global $id;
    //setcookie('carID', $lastID, time() + (86400 * 7)); // 86400 = 1 day
    header('Location: profile.php');
    return;
}

?>

<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
	<meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title>CarSpy - Add Device</title>

    <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link rel="stylesheet" href="css/normalize.css" />
  
  <link rel="stylesheet" href="css/addcar.css" />
  <!-- 
  <link rel="stylesheet" src="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css">
   -->

  <script src="js/vendor/custom.modernizr.js"></script>
 

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
	
	<div class= "loginshadow">
		    
		    <div class="large-3 ">
		    	
			    <form  action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="addCar" class="form-horizontal">
	                   
	                <h2 style="color:lightgray; text-align:center">Please Enter Your Car & Device Info</h2> 
	                
	               <?php if($notfound){ ?>

	               		<h4 style="color:red; background-color:lightgray; text-align:center">Please check your CarSpy Key and try again.</h4>



	               <?php }?>
			        <div class="control-group">
					    <label class="control-label" for="vehicleID">CarSpy Key</label>
					    <div class="controls">
			        		<input type="text" id="vehicleID" name="vehicleID" placeholder="12345" required="required">
			        	</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="make">Car Make</label>
					    <div class="controls">
			        		<input type="text" id="make" name="make" placeholder="DeLorean">
		        		</div>
				    </div>
				    <div class="control-group">
					    <label class="control-label" for="model">Car Model</label>
					    <div class="controls">
			        		<input type="text" id="model" name="model" placeholder="Prius">
			        	</div>
			        </div>
			        <div class="control-group">
					    <label class="control-label" for="color">Car Color</label>
					    <div class="controls">
			        		<input type="text" id="color" name="color" placeholder="Silver">
			        	</div>
			        </div>
			        <div class="control-group">
					    <label class="control-label" for="year">Car Year</label>
					    <div class="controls">
			        		<input type="text" id="year" name="year" placeholder="1984">
			        	</div>
			        </div>
			        <div class="control-group">
					    <label class="control-label" for="licensePlate">License Plate</label>
					    <div class="controls">
			        		<input type="text" id="licensePlate" name="licensePlate" placeholder="123-456">
			        	</div>
			        </div>
			        <div class="control-group">
					    <label class="control-label" for="owner">Car Owner</label>
					    <div class="controls">
			        		<input type="text" id="owner" name="owner" placeholder="Juan del Pueblo">
			        	</div>
			        </div>


			        
				        
			        	<!-- Button to trigger modal 
						<a href="#register" role="button" class="btn btn-large" data-toggle="modal" data-target="#register">Register</a>-->
				    <button class="btn btn-large btn-warning" type='submit' name="submit" value="add" >Enter CarSpy</button>
				        
					
					
				
					<!-- Modal -->
					
					
	            </form>

	           

	</div>

	 <!-- /container --> 

<!-- 
  <script>
  document.write('<script src=' +
  ('__proto__' in {} ? '/js/vendor/zepto' : '/js/vendor/jquery') +
  '.js><\/script>')
  </script>
 -->
  	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  	<!-- 
  	<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
     <script>
        $(function() {
            $( "#datepicker" ).datepicker({ minDate: 0, maxDate: "+2Y" });
            $( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
        });
    </script>
  	 -->
  	<script src="js/foundation/foundation.js"></script>

	
    <script src="js/bootstrap.min.js"></script>

	

	
  
  <script>
    $(document).foundation();
  </script>
</body>
</html>
