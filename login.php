<?php // Page for logging in and for registering if you are a new user.

// Checks if the user is logged in and redirects to index
if(isset($_COOKIE['loggedin'])){
    $loggedin = true;
    header('Location: index.html');
    return;
}

$loggedin = false;
$id = 0;

// When the user presses the submit button this code will run
if ( count($_POST) > 0) {
    require_once('db.php');
    $db = db::getInstance();

    // If the Sign Up button was pressed run this code
    if($_POST['submit'] != 'Login'){

        // Encrypts the password the user entered
        $password = md5 ( $_POST['password'] );

        // Creates a new tuple in the table User with the info entered
        $sql = "INSERT INTO User
                SET

                    firstName = '{$_POST['first-name']}',
                    lastName = '{$_POST['last-name']}',
                    email = '{$_POST['email']}',
                    password = '{$password}',
                    age = '{$_POST['age']}',
                    gender = '{$_POST['gender']}',
                    work = '{$_POST['work']}',
                    securityQuestion = '{$_POST['question']}',
                    securityAnswer = '{$_POST['answer']}'
        ";

        $stmt = $db->prepare($sql);
        // $stmt->bindValue(':vName', , PDO::PARAM_STR);
        $stmt->execute();
        $loggedin = true;
        // Gets the ID of the new created user
        $id = $db->lastInsertId();

        // If the user wanted to upload a picture run this code
        if ($_FILES["photo"]["error"] == 0) {
          // Code for preparing the picture for sotring in the database
          $type = str_replace('image/', '', $_FILES['photo']['type']);

          $fileName = $_FILES['photo']['name'];
          $tmpName  = $_FILES['photo']['tmp_name'];
          $fileSize = $_FILES['photo']['size'];
          $fileType = $_FILES['photo']['type'];

          $fp      = fopen($tmpName, 'r');
          $content = fread($fp, filesize($tmpName));
          $content = addslashes($content);
          fclose($fp);

          // Query to insert the info into the table Picture
          $sql = "INSERT INTO Picture
                  SET
                    userID = '{$id}',
                    ext = '{$type}',
                    data = '{$content}'";

          $stmt = $db->prepare($sql);
          $stmt->execute();
          // Gets the ID of the inserted picture
          $picID = $db->lastInsertId();

          // Updates the user's info with the id of the picture
          $sql = "UPDATE User
                  SET
                    profilePicture = '{$picID}'
                  WHERE userID = '{$id}'";

            $stmt = $db->prepare($sql);
            $stmt->execute();
        }
        else{
            // Default photo

        }
    }

    // If the user pressed the Login button
    else {
        // Query to get the user's info according to the username and password provided
        $password = md5 ( $_POST['password'] );
        $sql = "SELECT 
                    userID,
                    userName,
                    password
                FROM User
                WHERE userName = '{$_POST['username']}'
                AND password = '{$password}';
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        // If a matching user was found set loggedin to true, and get the user's ID
        if(count($result) > 0) {
            $loggedin = true;
            $id = $result[0]['userID'];
        }
    }
}

// Set a cookie for maintaining the session with the user. Expires in a day.
if($loggedin) { 
    setcookie('loggedin', $id, time() + (86400 * 7)); // 86400 = 1 day
    header('Location: index.php');
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
  

  <script src="js/vendor/custom.modernizr.js"></script>

</head>
<body>

<!--
	<div id="topnav">
		<div class="row">
		    
		    <div class="large-8 columns">
		    	<a href="/">
		    		<img src="img/CarSpyGray.png" style="height:60px;margin-top:10px;">
		    	</a>
		    </div>
		    <div class="large-4 columns"><a href="/"><h3>username</h3></a></div>
		    
		   
		</div>  
	</div>

-->
	
	<div class= "shadowbox">
		    
		    <div class="large-3 ">
		    	
		    	<!--
	                <form  action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="login">
	                    <h2 style="text-align:center; color:white;">Login</h2>
	                            <div>
	                                <label for="username">Username</label>	                                
	                                    
	                                    <input id="username" type="text" name="username" />	                                
	                            </div>
	                            <div>
	                                <label for="password">Password</label>	                               
	                                    
	                                    <input id="password" type="password" name="password" />	                                
	                            </div>
	                                       
	                        <input type='submit' name="submit" value="Login"  />
	            	</form>
	            
	            

			      <form class="form-signin">
			        <h2 class="form-signin-heading">Login</h2>
			        <input type="text" class="input-block-level" placeholder="Email address">
			        <input type="password" class="input-block-level" placeholder="Password">
			        
			        <button class="btn btn-large btn-primary" type="submit">Sign in</button>
			      </form>
			      -->

			    <form  action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="login" class="form-signin">
	                    
	                <!--<h2 class="form-signin-heading">Enter CarSpy</h2> -->
	                <img src="img/CarSpy_black.png" style="margin-bottom:25px;">
	                
			        <input type="text" class="input-block-level" placeholder="Email">
			        <input type="password" class="input-block-level" placeholder="Password">
			        
			        <div class="btn-group" >
				        
			        	<!-- Button to trigger modal -->
						<a href="#register" role="button" class="btn btn-large" data-toggle="modal">Register</a>
				        <button class="btn btn-large btn-warning btn-primary" type="submit">Sign in</button>
				        
					</div>
					 
					<!-- Modal -->
					
	            </form>
	            <form class="form-horizontal">
					<div id="register" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						 <div class="modal-header">
						    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						    <h3 id="myModalLabel">Register with CarSpy</h3>
						  </div>

						  <div class="modal-body">
						    	
							  <div class="control-group">
							    <label class="control-label" for="inputEmail">Email</label>
							    <div class="controls">
							      <input type="text" id="inputEmail" placeholder="Email">
							    </div>
							  </div>
							  <div class="control-group">
							    <label class="control-label" for="inputPassword">Password</label>
							    <div class="controls">
							      <input type="password" id="inputPassword" placeholder="Password">
							    </div>
							  </div>
							  
							
						  </div>
						  <div class="modal-footer">
						    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
						    <button type="submit" class="btn btn-warning btn-primary">Register</button>
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

	<script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

	

	
  
  <script>
    $(document).foundation();
  </script>
</body>
</html>
