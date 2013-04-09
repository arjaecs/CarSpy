<?php // Page for logging in and for registering if you are a new user.
require_once('db.php');
require_once('checkAuth.php');
require_once('logout.php');

if (!$loggedin && !isset($id)) {
    header('Location: login.php');
    return;
}

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


// if(!isset($user)){
//     header('Location: login.php');
//     return;
// }

// When the user presses the submit button this code will run
if ( count($_POST) > 0) {
    
    


	if($_POST['submit'] == 'add'){

		$notfound = false;
		$car = array('vehicleID' => $_POST['vehicleID']);

		$sql = "SELECT make, model, licensePlate FROM Vehicle WHERE vehicleID = :car;";

	    $stmt = $db->prepare($sql);
	    $stmt->execute($car);
	    $result = $stmt->fetchAll();

	    if (count($result)==1) {
	    	
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
	    if($) { 
		//global $id;
	    setcookie('carID', $car, time() + (86400 * 7)); // 86400 = 1 day
	    header('Location: home.php');
	    return;
		}
	}
	else{
		$notfound = true;
	}



}
//var_dump($_SESSION);

// Set a cookie for maintaining the session with the user. Expires in a day.



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
  
  <link rel="stylesheet" href="css/login.css" />
  <!-- 
  <link rel="stylesheet" src="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css">
   -->

  <script src="js/vendor/custom.modernizr.js"></script>
 

</head>
<body>
	
	<div class= "shadowbox">
		    
		    <div class="large-3 ">
		    	
			    <form  action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="login" class="form-signin">
	                <h1>Hello <?php echo $user['firstName']?>!</h1>    
	                <h2 class="form-signin-heading">Please Enter Your CarSpy Info</h2> <!-- 
	                <img src="img/CarSpy_black.png" style="margin-bottom:25px;">
	                 -->
			        <!--<input type="text" class="input-block-level" placeholder="Email" required="required">-->
			        
			        <input class="input-block-level" id="vehicleID" name="vehicleID" placeholder="CarSpy ID" required="required">

			        <input class="input-block-level" id="make" name="make" placeholder="DeLorean">
			        <input class="input-block-level" id="model" name="model" placeholder="Prius">
			        <input class="input-block-level" id="color" name="color" placeholder="Silver">
			        <input class="input-block-level" id="year" name="year" placeholder="1984">
			        <input class="input-block-level" id="licensePlate" name="licensePlate" placeholder="123-456">
			        <input class="input-block-level" id="owner" name="owner" placeholder="Juan del Pueblo">


			        <?php if($notfound){
						echo "<p id='response'>Your Device was not found</p>";
					}
						?>
			        
				        
			        	<!-- Button to trigger modal 
						<a href="#register" role="button" class="btn btn-large" data-toggle="modal" data-target="#register">Register</a>-->
				    <button class="btn btn-large btn-warning btn-primary" type='submit' name="submit" value="add" >Enter CarSpy</button>
				        
					
					
				
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
