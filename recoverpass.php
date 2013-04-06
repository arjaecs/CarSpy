<?php
// Connect to server and select databse.
// $lcConnection = mysql_connect("localhost", "lifeconnection","peluche");
// mysql_select_db("lifeConnectionDB",$lcConnection); 
require_once('db.php');
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>


<!DOCTYPE html>

<head>

<title>Recover Password</title>

</head>

<body>


<!-- InstanceBeginEditable name="EditRegion4" -->
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="669" align="right"><div id="after_login">User:
      <?php $user['email'];  ?>
  </tr>
</table>


<table width="900" height="30" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><a href="../index.php">HOME</a> || <a href="login.php">LOGIN</a></td>
  </tr>
</table>



<!-- InstanceEndEditable -->




<table width="900" height="170" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img src="../Image/banners/globeconnection.jpg" width="900" height="130" alt="banner" /></td>
  </tr>
</table>

<!-- InstanceBeginEditable name="EditRegion3" -->
<table width="900" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td width="557" align="right" bgcolor="#FFFFFF">&nbsp;
        <h2>Recover Password</h2>
<form id="formPass" name="formPass" method="post" action="">
  <p>
    <label for="parent_username">Username:</label>
    <input type="text" name="parent_username" id="parent_username" />
  </p>
  
  <p>
    <label for="parent_email">Email:</label>
    <input type="text" name="parent_email" id="parent_email" />
  </p>
  
   <p>
    <label for="security_phrase">Security Phrase:</label>
    <input type="text" name="security_phrase" id="security_phrase" />
  </p>
    
    <p>
		
    </p>
    
     <p>
    <input type="submit" name="request" id="request" value="Request" />
  </p>
        
</form>

    </td>
    <td width="323" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>



<!-- InstanceEndEditable -->

</body>
<!-- InstanceEnd --></html>

<?php 
		if ( $_POST['request'] == true)
		{
		// Form Information
		// $userEmail = $_POST['parent_email'];
		// $userEmail = stripslashes($_POST['parent_email']);
		$email = mysql_real_escape_string(stripslashes($_POST['email']));
		
		// $userName = $_POST['parent_username'];
		// $userName = stripslashes($userName);
		// $userName = mysql_real_escape_string($userName);
		

		// $userPhrase = $_POST['security_phrase'];
		// $userPhrase = stripslashes($userPhrase);
		// $userPhrase = mysql_real_escape_string($userPhrase);
		
		//Query email

		
		$sql = "SELECT `password` FROM `parent` WHERE `parent_username`='$userName' AND `parent_phrase`='$userPhrase' AND `parent_email`='$userEmail'";
		$res = mysql_query($sql) or die ("Error: ".mysql_error());
		$rows = mysql_num_rows($res);

		echo $rows;
		//**********if match rows = 1
		if((int)$rows == 1)
		{
		$pass = mysql_result($res,0);
			
		//define the receiver of the email
		$to =  $userEmail;
		//define the subject of the email
		$subject = 'Password Recovery'; 
		//define the message to be sent. Each line should be separated with \n
		$message = "Username: $userName Password: $pass"; 
		//define the headers we want passed. Note that they are separated with \r\n
		$headers = "From: YourLifeConnection@lifeconnection.com\r\nReply-To: YourLifeConnection@lifeconnection.com";
		//send the email
		$mail_sent = mail( $to, $subject, $message, $headers );
		//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
		echo $mail_sent ? "Mail sent" : "Mail failed";
		}
		}
		?>