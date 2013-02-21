<?php

$coordsID = $_GET['coordID'];

//if (!isset($coordID)) {
  //  header('Location: index.php');
    //return;
//}

// Query to get the venue's info
$db = db::getInstance();
$sql = "SELECT 
            C.coordID, 
            C.userID,
            date_format(C.datetime, '%a., %b %D, %Y. %l: %i %p'),
            C.GPS,  
            C.street,
            C.city, 
            C.state, 
            C.zipcode
        FROM Coords C
        WHERE C.coordID = {$coordsID};
";


$stmt = $db->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll();


$coords = $result[0];



?>