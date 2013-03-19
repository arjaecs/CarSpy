<?php // Page for logging in and for registering if you are a new user.
session_start();


if(isset($_COOKIE['loggedin'])){
    $loggedin = true;
    header('Location: profile.php');
    return;
}

$loggedin = false;
$id = 0;

// When the user presses the submit button this code will run
if ( count($_POST) > 0) {
    require_once('db.php');
    

    // If the Register button was pressed run this code
   if($_POST['submit'] != 'Login'){

    	$db = db::getInstance();
        // Encrypts the password the user entered
        $password = md5 ( $_POST['password'] );

        $date = $_POST['date'];

        // Creates a new tuple in the table User with the info entered
        $sql = "INSERT INTO User
                SET

                    password = '{$password}',
                    firstName = '{$_POST['firstName']}',
                    lastName = '{$_POST['lastName']}',
                    email = '{$_POST['email']}',
                    phone = '{$_POST['phone']}',
                    birth = '{$date}',
                    address =  '{$_POST['address']}',
                    gender = '{$_POST['gender']}'
        ";

        $stmt = $db->prepare($sql);
        // $stmt->bindValue(':vName', , PDO::PARAM_STR);
        $stmt->execute();
       $loggedin = true;
        $id = $db->lastInsertId();

        
    }

    // If the user pressed the Login button
    else {
    	//echo "eureka";
    	$db = db::getInstance();
    //     // Query to get the user's info according to the username and password provided
    	$salt = 'wkjhgkasflkjh';
		$cookie_value = md5($salt . $_POST['password']);
        //$password = md5 ( $_POST['password'] );
        //var_dump($password);
        $sql = "SELECT 
                    userID,
                    email,
                    password,
                    firstName,
                    lastName
                FROM User
                WHERE email = '{$_POST['email']}';
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();


        // If a matching user was found set loggedin to true, and get the user's ID
        // if(count($result) > 0) {
        //     $loggedin = true;
        //     $id = $result[0]['userID'];
        // }

        //var_dump($result[0]['password']);
        //var_dump(md5($_POST['password']));

        if ($result[0]['password'] == md5($_POST['password'])) //Remember to encrypt our value
			{
				//var_dump($loggedin);
			//Login success - set session cookie
			$loggedin = true;	
			$id = $result[0]['userID'];
			//$_SESSION['userID']=$result[0]['userID'];
			//$_SESSION['password']=$cookie_value;
			//header ("Location: home.php"); //Redirect the user to a logged in page
			//exit; //Do not display any more script for this page
			//return;
			}
        
        
        
   }

}
//var_dump($_SESSION);

// Set a cookie for maintaining the session with the user. Expires in a day.
if($loggedin) { 
	global $id;
    setcookie('loggedin', $id, time() + (86400 * 7)); // 86400 = 1 day
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
	                    
	                <!--<h2 class="form-signin-heading">Enter CarSpy</h2> -->
	                <img src="img/CarSpy_black.png" style="margin-bottom:25px;">
	                
			        <!--<input type="text" class="input-block-level" placeholder="Email" required="required">-->
			        <input id="email" class="input-block-level" name="email" type="email" placeholder="Email" required="required">
			        <!--<input type="password" class="input-block-level" placeholder="Password" required="required">-->
			        <input type="password" class="input-block-level" id="password" name="password" placeholder="Password" required="required">
			        
			        <div class="btn-group" >
				        
			        	<!-- Button to trigger modal -->
						<a href="#register" role="button" class="btn btn-large" data-toggle="modal">Register</a>
				        <button class="btn btn-large btn-warning btn-primary" type='submit' name="submit" value="Login" >Sign in</button>
				        
					</div>
					 
					<!-- Modal -->
					
	            </form>
	            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="create-user">
					<div id="register" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						 <div class="modal-header">
						    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						    <h3 id="myModalLabel">Register with CarSpy</h3>
						  </div>

						  <div class="modal-body">
						    
						    <div class="control-group">
							    <label class="control-label" for="firstName">First Name</label>
							    <div class="controls">
							      <input type="text" id="firstName" name="firstName" placeholder="First Name" required="required">
							    </div>
							  </div>
							  <div class="control-group">
							    <label class="control-label" for="lastName">Last Name</label>
							    <div class="controls">
							      <input type="text" id="lastName" name="lastName" placeholder="Last Name" required="required">
							    </div>
							  </div>	
							  <div class="control-group">
							    <label class="control-label" for="email">Email</label>
							    <div class="controls">
							      <input id="email" name="email" type="email" placeholder="example@email.com" required="required">
							      <!--<input type="text" id="inputEmail" placeholder="Email"> -->
							    </div>
							  </div>
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
							      <input type="tel" id="phone" name="phone" placeholder="787 123 4567">
							    </div>
							  </div>
							  <div class="control-group">
							    <label class="control-label" for="date">Date of Birth</label>
							    <div class="controls">
							      <input type="text" id="date" name="date" placeholder="YYYY-MM-DD"/>
							    </div>
							  </div>
							  <div class="control-group">
							    <label class="control-label" for="address">Address</label>
							    <div class="controls">
							      <input type="text" id="address" name="address" placeholder="#Street City, State Zip">
							    </div>
							  </div>
						  </div>
						  <div class="modal-footer">
						    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
						    <button type='submit' name="submit" value="Register" class="btn btn-warning btn-primary">Register</button>
						  </div>
					</div>
				</form>
			    

		    </div>

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
  	<script src="js/foundation/foundation.js"></script><!--
	
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

	
    <script src="js/bootstrap.min.js"></script>

	

	
  
  <script>
    $(document).foundation();
  </script>
</body>
</html>
