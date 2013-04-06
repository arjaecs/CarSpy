<?php 
require_once('db.php');

$session = json_decode($_GET['sessionID']); //$_GET['sessionID'];

$db = db::getInstance();


$sql = "SELECT picID,
						sessionID,
						path
						FROM Picture
		WHERE sessionID = {$session};";


$stmt = $db->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll();

$pics = array();
for ($i = 0; $i <count($result); $i++){

 $pics[] = array( 
 	'sessionID' => $result[$i]['sessionID'],
 	'path' => $result[$i]['path']
 	)
 );
}


echo json_encode($pics);


return;




?>

