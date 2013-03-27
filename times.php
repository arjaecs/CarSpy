<?php 
require_once('db.php');

$date = $_GET['date'];

$db = db::getInstance();



// Query to get the user's info if it's his/her own profile
$sql = "SELECT
			sessionID,
			vehicleID,
			date,
			time
			FROM Session
			WHERE date = {$date};";


$stmt = $db->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll();

$times = array();
for ($i = count($result) - 1; $i >= 0; $i--){
 //var_dump($result[$i]);
 //var_dump($result[$i]['time']);
 $times[] = $result[$i]['time'];
}

//var_dump($times);


// foreach ($result as $time) {
// 	$times[$time]=$time;
// }

echo json_encode($times);


return;

?>

