<?php 
require_once('db.php');

$email = $_GET['email'];
// $password = md5 ($_GET['password']);

// var_dump($_GET['password']);
// var_dump($password);

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
			WHERE email = {$email}";

	$stmt = $db->prepare($sql);
	$stmt->execute();

	$result = $stmt->fetchAll();
	
	$profile = $result[0];


	if(!isset($profile)){

		$user = array();

	}
	else{

		//var_dump($profile);
	$user = array('userID' => $user['userID'],
	 	'name' => array(
	 	'firstName' => $profile['firstName'],
	 	'lastName' => $profile['lastName']),
	 	'email' => $profile['email'],
	 	'phone' => $profile['phone'],
	 	'birthday' => $profile['birth'],
	 	'address' => $profile['address'],
	 	'gender' => $profile['gender']);
	

	}

	
	echo json_encode($user);
return;

?>

