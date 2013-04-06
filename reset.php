<?php 
require_once('db.php');

//$session = $_GET['sessionID'];
$email = $_GET['email'];//$_GET['email'];

//var_dump($email);

$db = db::getInstance();

$sql = "SELECT
				userID,
				password,
				email
			FROM User
			WHERE email = {$email};";

	$stmt = $db->prepare($sql);
	$stmt->execute();

	$result = $stmt->fetchAll();
	
	$profile = $result[0];
	//var_dump($profile);
	//$email = $profile["email"];
	//$mail = mysql_real_escape_string(stripslashes($profile['email']));
	$pass = '81dc9bdb52d04dc20036dbd8313ed055';

	if(!isset($profile)){

		$reset = array('message' => 'No email found');

	}
	else{
	
	$passsql = "UPDATE User
	            SET
	                password = '{$pass}'
	            WHERE email = '{profile['email']';
	    ";

	    $stmt = $db->prepare($passsql);
	    $stmt->execute();	
	//define the receiver of the email
	$to =  $mail;
	//define the subject of the email
	$subject = 'Password Recovery'; 
	//define the message to be sent. Each line should be separated with \n
	$message = "Your new temporary Password is: $pass . Please change as soon as possible."; 
	//define the headers we want passed. Note that they are separated with \r\n
	$headers = "From: alvaro.calderon@upr.edu\r\nReply-To: alvaro.calderon@upr.edu";
	//send the email
	$mail_sent = mail( $to, $subject, $message, $headers );
	//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
	//echo $mail_sent ? "Mail sent" : "Mail failed";

	if(isset($mail_sent)){
		$reset = array('message' => 'Your email was sent successfully!');
	}
	else{
		$reset = array('message' => 'Please try again');
	}
	
		

	
	echo json_encode($reset);
return;

?>