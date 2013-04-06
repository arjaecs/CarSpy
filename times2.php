<?php 
require_once('db.php');

//$session = $_GET['sessionID'];
//$date = $_GET['date'];
//$car = $_GET['car'];

// $data = array(
// 	'car' => $_GET['car'],
// 	'date' => $_GET['date']
// 	);
//try{
$db = db::getInstance();



// Query to get the user's info if it's his/her own profile
$sql = "SELECT
			sessionID,
			vehicleID,
			date,
			time,
			lat,
			`long`,
			path1,
			path2,
			path3
		FROM Session
		WHERE vehicleID = :car AND date = :date ;";

$stmt = $db->prepare($sql);
//var_dump($stmt);
$stmt->bindValue(":car", (int)$_GET['car']);
//var_dump($stmt);
$stmt->bindValue(":date", $_GET['date']);
//var_dump($stmt);
$stmt->execute();
var_dump($stmt);
$result = $stmt->fetchAll();
var_dump($result);
$times = array();
for ($i = count($result) - 1; $i >= 0; $i--){
 //var_dump($result[$i]);
 //var_dump($result[$i]['time']);
 $times[] = array( 
 	'sessionID' => $result[$i]['sessionID'],
 	'time' => $result[$i]['time'],
 	'location' => array(
 		'latitude' => $result[$i]['lat'],
 		'longitude' => $result[$i]['long']),

 	'path1' => $result[$i]['path1'],
 	'path2' => $result[$i]['path2'],
 	'path3' => $result[$i]['path3']


 );
}
// }
// catch( PDOException $e )
// {
//     die("Exception");
// }

echo json_encode($times);


return;

?>

