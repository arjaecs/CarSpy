<?php 
require_once('db.php');

$session = $_GET['sessionID']; //$_GET['sessionID'];

$data = array('session' => $session);

$db = db::getInstance();


$sql = "SELECT picID,
						sessionID,
						path
						FROM Picture
		WHERE sessionID = :session;";				
		//WHERE sessionID = {$session};


$stmt = $db->prepare($sql);
$stmt->execute($data);

$result = $stmt->fetchAll();

$pics = array();
for ($i = 0; $i <count($result); $i++){

 $pics[] = array( 
 	
 	'path' => $result[$i]['path']
 	
 );
}


echo json_encode($pics);


return;




?>

