<?php // Script to search users,events,and venues

// Checks if the submit button was pressed on the search bar.
if (isset($_POST['submit'])) {
    $search = $_POST['submit'];

    $db = db::getInstance();

    // Query to find users with similar names to the input value
    $userSql = "SELECT 
            U.userName,
            U.userID,
            U.firstName,
            U.lastName
        FROM User U
        WHERE U.userName LIKE '%{$search}%'";

    $stmt = $db->prepare($userSql);
    $stmt->execute();
    $users = $stmt->fetchAll();

    // Query to find events with similar names to the input value
    $eventSql = "SELECT 
            E.eventID,
            E.eventName
        FROM Event E
        WHERE E.eventName LIKE '%{$search}%'";

    $stmt = $db->prepare($eventSql);
    $stmt->execute();
    $events = $stmt->fetchAll();

    // Query to find venues with similar names to the input value
    $venueSql = "SELECT 
            V.venueID,
            V.vName
        FROM Venue V 
        WHERE V.vName LIKE '%{$search}%'";

    $stmt = $db->prepare($venueSql);
    $stmt->execute();
    $venues = $stmt->fetchAll();

    echo json_encode(array(
        "users" => $users,
        "events" => $events,
        "venues" => $venues
    ));
    return;
}



?>