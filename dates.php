<?php 
require_once('db.php');

$car = $_GET['vehicleID'];

$db = db::getInstance();


$sesssql = "SELECT DISTINCT
					vehicleID,
					date,
					DATE_FORMAT(date, '%W, %M %e, %Y') as day
					FROM Session 
					WHERE vehicleID = {$car};";
	$stmt = $db->prepare($sesssql);
	$stmt->execute();

	$sessions = $stmt->fetchAll();
	
	$dates = array();
	for ($i = count($sessions) - 1; $i >= 0; $i--){
	 
	 // add each date to the end of the times array
	 $dates[] = array('date' => $sessions[$i]['date'], 'day' => $sessions[$i]['day'] );

	}

echo json_encode($dates);


return;

?>