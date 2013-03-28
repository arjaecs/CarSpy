<?php 
require_once('db.php');

$userID = $_GET['userID'];
$vehicleID = $_GET['vehicleID'];

// var_dump($_GET['password']);
// var_dump($password);

$db = db::getInstance();

// Query to get the user's info if it's his/her own profile
$carsql = "SELECT
				V.vehicleID,
				V.userID,
				V.make,
				V.model,
				V.color,
				V.year,
				V.licensePlate,
				V.owner
				FROM Vehicle V
				WHERE V.userID = {$userID} AND V.vehicleID = {$vehicleID};";

	$stmt = $db->prepare($carsql);
	$stmt->execute();

	$vehicles = $stmt->fetchAll();
	$car = $vehicles[0];

	if(!isset($car)){

		$vehicle = array();

	}
	else{

		//var_dump($profile);
	$vehicle = array('vehicleID' => $car['vehicleID'],
	 	
	 	'make' => $car['make'],
	 	'model' => $car['model'],
	 	'color' => $car['color'],
	 	'year' => $car['year'],
	 	'licensePlate' => $car['licensePlate'],
	 	'owner' => $car['owner']
	 	);
	

	}

	
	echo json_encode($vehicle);
return;

?>

