<?php // Page for logging in and for registering if you are a new user.
require_once('db.php');

// Checks if the user is logged in and redirects to index
if(isset($_COOKIE['loggedin'])){
    $loggedin = true;
    header('Location: home.php');
    
}
else {
	header('Location: login.php');
}
return;
?>
