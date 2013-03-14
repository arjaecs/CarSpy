<?php // Page for logging in and for registering if you are a new user.


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
  
  <link rel="stylesheet" href="css/profile.css" />
  

  <script src="js/vendor/custom.modernizr.js"></script>

</head>
<body>

	<div id="topnav">
		 <div id="cslogo">
		 	<a href="/"><img  src="img/CarSpyGray2.png"></a>
			<span>
				<a href="/"><h3 style="margin-top:-45px; margin-right:50px; font-style:italic;">username</h3>
				</a>
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
									<td>Alvaro Calderón</td>
									
								</tr>
								<tr>
									<td>Sex</td>
									<td>Male</td>
									
								</tr>
								<tr>
									<td>Birthday</td>
									<td>Feb. 30, 2013</td>
									
								</tr>
								<tr>
									<td>Email</td>
									<td>oh.my@gah.com</td>
									
								</tr>
								<tr>
									<td>Phone</td>
									<td>787 123 4567</td>
									
								</tr>
								<tr>
									<td>Address</td>
									<td>PO BOX 1234 San Juan, PR 00902</td>
									
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
									<td>Alvaro Calderón</td>
									
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
