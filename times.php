<?php 
require_once('db.php');

//$session = $_GET['sessionID'];
$date = $_GET['date'];
$car = $_GET['car'];

$db = db::getInstance();



// Query to get the user's info if it's his/her own profile
$sql = "SELECT
			sessionID,
			vehicleID,
			date,
			time,
			lat,
			`long`
		FROM Session
		WHERE vehicleID = {$car} AND date = {$date};";


$stmt = $db->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll();

$times = array();
for ($i = count($result) - 1; $i >= 0; $i--){
 //var_dump($result[$i]);
 //var_dump($result[$i]['time']);
 $times[] = array( 
 	'session' => $result[$i]['sessionID'],
 	'time' => $result[$i]['time'],
 	'location' => array(
 		'latitude' => $result[$i]['lat'],
 		'longitude' => $result[$i]['long'])
 	// ,
 	// 'path1' => $result[$i]['path1'],
 	// 'path2' => $result[$i]['path2'],
 	// 'path3' => $result[$i]['path3']


 );
}


echo json_encode($times);


return;

?>

