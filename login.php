<?php // Page for logging in and for registering if you are a new user.
//session_start();


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
   if($_POST['submit'] == 'Register'){

    	$db = db::getInstance();
        // Encrypts the password the user entered
        //$password = md5 ( $_POST['password'] );

        //$date = $_POST['date'];

        $data = array(

        	'password' => md5 ( $_POST['password'] ),
            'firstName' => $_POST['firstName'],
            'lastName' => $_POST['lastName'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'birth' => $_POST['date'],
            'address' =>  $_POST['address'],
            'gender' => $_POST['gender']	
        	);

        // Creates a new tuple in the table User with the info entered
        $sql = "INSERT INTO User
                SET

                    password = :password,
                    firstName = :firstName,
                    lastName = :lastName,
                    email = :email,
                    phone = :phone,
                    birth = :date,
                    address = :address,
                    gender = :gender;";

        $stmt = $db->prepare($sql);
        // $stmt->bindValue(':vName', , PDO::PARAM_STR);
        $stmt->execute($data);
       	$loggedin = true;
        $id = $db->lastInsertId();

        
    }

    // If the user pressed the Login button
    elseif($_POST['submit'] == 'Login') {
    	//echo "eureka";
    	$db = db::getInstance();
    //     // Query to get the user's info according to the username and password provided
    	//$salt = 'wkjhgkasflkjh';
		//$cookie_value = md5($salt . $_POST['password']);
        //$password = md5 ( $_POST['password'] );
        //var_dump($password);

        $sql = "SELECT 
                    userID,
                    email,
                    password,
                    firstName,
                    lastName
                FROM User
                WHERE email = :email;";
        
        $data = array('email' => $_POST['email']);

        $stmt = $db->prepare($sql);
        $stmt->execute($data);
        $result = $stmt->fetchAll();

        $nope = false;
        $reset = "";
        // If a matching user was found set loggedin to true, and get the user's ID

        if ($result[0]['password'] == md5($_POST['password'])) //Remember to encrypt our value
			{
				
			//Login success - set session cookie
			$loggedin = true;	
			$id = $result[0]['userID'];

			setcookie('loggedin', $id, time() + (86400 * 7)); // 86400 = 1 day
		    header('Location: home.php');
		    return;
			
			}
		else{
			//echo "<p>User/Password Combination Incorrect</p>";
			$nope = true;
			$reset = 'Email/Password Combination Incorrect';
		}

	}
	else{

		$db = db::getInstance();

		//$email = $_POST['mail'];
		//var_dump($email);

		$sql = "SELECT
			userID,
			password,
			email
		FROM User
		WHERE email = :mail;";
        
		$notfound = false;
        $data = array('mail' => $_POST['mail']);
        $stmt = $db->prepare($sql);
        $stmt->execute($data);
		$result = $stmt->fetchAll();
		$profile = $result[0];
		
		$pass = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
		$mdpass = md5($pass);

		if(!isset($profile)){

			//Email sent to recover password is not found within the databases
			$notfound = true;
			$reset = 'Email not found';

		}
		else{
		
			$passsql = "UPDATE User
			            SET
			                password = '{$mdpass}'
			            WHERE email = '{$_POST['mail']}';";

		    $stmt = $db->prepare($passsql);
		    $stmt->execute();	
			//define the receiver of the email
			$to =  $data['mail'];
			//define the subject of the email
			$subject = 'Password Recovery'; 
			//define the message to be sent. Each line should be separated with \n
			$message = "Your temporary Password is: ".$pass.". Please change as soon as possible."; 
			//define the headers we want passed. Note that they are separated with \r\n
			$headers = "From: alvaro@carspy.com\r\nReply-To: alvaro.calderon@upr.edu";
			
			//send the email
			$mail_sent = mail( $to, $subject, $message, $headers );
			

			$email_sent = false;
			if(isset($mail_sent)){
				$email_sent = true;
				$reset = 'Your email was sent successfully!';
			}
			else{
				$reset = 'Please try again';
			}
		}

	//echo $reset;

	}

}

//Set a cookie for maintaining the session with the user. Expires in a day.
if($loggedin) { 
	//global $id;
    setcookie('loggedin', $id, time() + (86400 * 7)); // 86400 = 1 day
    header('Location: home.php');
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
			        <?php if($nope){
						echo "<p id='response'>".$reset."</p>";
						}elseif ($notfound) {
							echo "<p id='response'>".$reset."</p>";
						}
						elseif ($email_sent) {
							echo "<p id='response' style='color:green'>".$reset."</p>";
						}
							else{
								echo "<p id='response'>".$reset."</p>";
							}
						?>
			        <div class="btn-group" >
				        
			        	<!-- Button to trigger modal -->
						<a href="#register" role="button" class="btn btn-large" data-toggle="modal" data-target="#register">Register</a>
				        <button class="btn btn-large btn-warning btn-primary" type='submit' name="submit" value="Login" >Sign in</button>
				        
					</div>
					
					<div id="forgot"><a href="#reset" data-toggle="modal" data-target="#reset">Forgot Password?</a></div>
					<!-- Modal -->
					
					
	            </form>

	            

	            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="create-user">
					<div id="register" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="create-user" aria-hidden="true">
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
							    <label class="control-label" for="mail">Email</label>
							    <div class="controls">
							      <input id="email" name="mail" type="mail" placeholder="example@email.com" required="required">
							      <!--<input type="text" id="inputEmail" placeholder="Email"> -->
							    </div>
							  </div>
							  <div class="control-group">
							    <label class="control-label" for="password">Password</label>
							    <div class="controls">
							      <input type="password"  name="pass" placeholder="Password" required="required">
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

				<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="resetPassword">
					<div id="reset" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="resetPassword" aria-hidden="true">
						 <div class="modal-header">
						    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						    <h3 id="resetPassword" style="text-align:center;">Reset Password</h3>
						  </div>

						  <div class="modal-body">
						    
						    
							  
							    
							    
							    
							      <input name="mail" type="mail" class="input-block-level" placeholder="example@email.com" required="required">
							      <!--<input type="text" id="inputEmail" placeholder="Email"> -->
							   
								
							  
						  
						  <div class="modal-footer">
						    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
						    <button type='submit' name="submit" value="Reset" class="btn btn-warning btn-primary">Send Email</button>
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
