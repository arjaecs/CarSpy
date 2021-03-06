<?php // Page for logging in and for registering if you are a new user.


if(isset($_COOKIE['loggedin'])){
    $loggedin = true;
    header('Location: profile.php');
    return;
}

$loggedin = false;
$id = 0;

if ( count($_POST) > 0) {
    require_once('db.php');
    

    // If the Register button was pressed 
   if($_POST['submit'] == 'Register'){

    	$db = db::getInstance();

    	$data = array('email' => $_POST['regMail']);

    	$prev = "SELECT email FROM User WHERE email = :email";

    	$stmt = $db->prepare($prev);
        $stmt->execute($data);
        $existing = $stmt->fetchAll();

        $exists = false;
        if(count($existing)>0){ // User wanted to register a new account with a pre-existing email
        	$exists = true;
        	$reset = 'Existing account found, try again!';
        }
        else{ // Email wasn't found within the database

		$psw= md5 ( $_POST['regPass'] );

		$data = array(
						'password' => $psw,
                    'firstName' => $_POST['regFirstName'],
                    'lastName' => $_POST['regLastName'],
                    'email' => $_POST['regMail'],
                    'phone' => $_POST['regPhone'],
                    'birth' => $_POST['regDate'],
                    'address' =>  $_POST['regAddress'],
                    'gender' => $_POST['regGender']
			);
        
        // $sql = "INSERT INTO User
        //         SET

        //             password = '{$psw}',
        //             firstName = '{$_POST['firstName']}',
        //             lastName = '{$_POST['lastName']}',
        //             email = '{$_POST['mail']}',
        //             phone = '{$_POST['phone']}',
        //             birth = '{$_POST['date']}',
        //             address =  '{$_POST['address']}',
        //             gender = '{$_POST['gender']}'
        // ";

        $sql = "INSERT INTO User
                SET

                    password = :password,
                    firstName = :firstName,
                    lastName = :lastName,
                    email = :email,
                    phone = :phone,
                    birth = :birth,
                    address =  :address,
                    gender = :gender
        ";


        $stmt = $db->prepare($sql);
        // $stmt->bindValue(':vName', , PDO::PARAM_STR);
        $stmt->execute($data);
       	$loggedin = true;
        $id = $db->lastInsertId();
        setcookie('loggedin', $id, time() + (86400 * 7)); // 86400 = 1 day
	    header('Location: addcar.php');
	    return;

        }
    }

    // If the user pressed the Login button
    elseif($_POST['submit'] == 'Login') {
    	
    	$db = db::getInstance();

    	// Query to get the user's info according to the username and password provided
    	
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

			$nope = true;
			$reset = 'Email/Password Combination Incorrect';
		}

	}
	else{

		//Reset Password

		$db = db::getInstance();

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
			//Email found, reset email with randomly generated one and send email
		
			$passsql = "UPDATE User
			            SET
			                password = '{$mdpass}'
			            WHERE email = '{$_POST['mail']}';";

		    $stmt = $db->prepare($passsql);
		    $stmt->execute();	

			//Email receiver
			$to =  $data['mail'];

			//define the subject of the email
			$subject = 'Password Recovery'; 

			//define the message to be sent. Each line should be separated with \n
			$message = "Your temporary Password is: ".$pass.". \n\nPlease change as soon as possible."; 

			//define the headers we want passed. Note that they are separated with \r\n
			$headers = "From: PasswordRecovery@carspy.com\r\nReply-To: alvaro.calderon@upr.edu";
			
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
  <link href='http://fonts.googleapis.com/css?family=Metrophobic|Belleza|Gruppo' rel='stylesheet' type='text/css'>

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
			        <?php 
			        	if($exists){
			        		echo "<p id='response'>".$reset."</p>";
			        	}
			        	elseif($nope){
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
							    <label class="control-label" for="regFirstName">First Name</label>
							    <div class="controls">
							      <input type="text" id="regFirstName" name="regFirstName" placeholder="First Name" required="required">
							    </div>
							  </div>
							  <div class="control-group">
							    <label class="control-label" for="regLastName">Last Name</label>
							    <div class="controls">
							      <input type="text" id="regLastName" name="regLastName" placeholder="Last Name" required="required">
							    </div>
							  </div>	
							  <div class="control-group">
							    <label class="control-label" for="regMail">Email</label>
							    <div class="controls">
							      <input id="regMail" name="regMail" type="email" placeholder="example@email.com" required="required">
							      <!--<input type="text" id="inputEmail" placeholder="Email"> -->
							    </div>
							  </div>
							  <div class="control-group">
							    <label class="control-label" for="regPass">Password</label>
							    <div class="controls">
							      <input type="password"  id="regPass" name="regPass" placeholder="Password" required="required">
							    </div>
							  </div>
							  <div class="control-group">
							    <label class="control-label" for="regGender">Gender</label>
							    <div class="controls">
							    	<select name="regGender" id="regGender">
                                        <option value='Male'>Male</option>
                                        <option value='Female'>Female</option>
                                    </select>
							    </div>
							  </div>
							  <div class="control-group">
							    <label class="control-label" for="regPhone">Phone</label>
							    <div class="controls">
							      <input type="tel" id="regPhone" name="regPhone" placeholder="787 123 4567">
							    </div>
							  </div>
							  <div class="control-group">
							    <label class="control-label" for="regDate">Date of Birth</label>
							    <div class="controls">
							      <input type="text" id="regDate" name="regDate" placeholder="YYYY-MM-DD"/>
							    </div>
							  </div>
							  <div class="control-group">
							    <label class="control-label" for="regAddress">Address</label>
							    <div class="controls">
							      <input type="text" id="regAddress" name="regAddress" placeholder="#Street City, State Zip">
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
							      
							   
								
							  
						  
						  <div class="modal-footer">
						    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
						    <button type='submit' name="submit" value="Reset" class="btn btn-warning btn-primary">Send Email</button>
						  </div>
					</div>
				</form>
			    

		    </div>

	</div>

	 <!-- /container --> 

  	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>

  	<script src="js/foundation/foundation.js"></script>

	
    <script src="js/bootstrap.min.js"></script>

	

	
  
  <script>
    $(document).foundation();
  </script>
</body>
</html>
