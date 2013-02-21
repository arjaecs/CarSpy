<?php // Page for logging in and for registering if you are a new user.

// Checks if the user is logged in and redirects to index
if(isset($_COOKIE['loggedin'])){
    $loggedin = true;
    header('Location: index.php');
    return;
}

$loggedin = false;
$id = 0;

// When the user presses the submit button this code will run
if ( count($_POST) > 0) {
    require_once('db.php');
    $db = db::getInstance();

    // If the Sign Up button was pressed run this code
    if($_POST['submit'] != 'Login'){

        // Encrypts the password the user entered
        $password = md5 ( $_POST['password'] );

        // Creates a new tuple in the table User with the info entered
        $sql = "INSERT INTO User
                SET
                    userName = '{$_POST['username']}',
                    firstName = '{$_POST['first-name']}',
                    lastName = '{$_POST['last-name']}',
                    email = '{$_POST['email']}',
                    password = '{$password}',
                    age = '{$_POST['age']}',
                    gender = '{$_POST['gender']}',
                    work = '{$_POST['work']}',
                    securityQuestion = '{$_POST['question']}',
                    securityAnswer = '{$_POST['answer']}'
        ";

        $stmt = $db->prepare($sql);
        // $stmt->bindValue(':vName', , PDO::PARAM_STR);
        $stmt->execute();
        $loggedin = true;
        // Gets the ID of the new created user
        $id = $db->lastInsertId();

        // If the user wanted to upload a picture run this code
        if ($_FILES["photo"]["error"] == 0) {
          // Code for preparing the picture for sotring in the database
          $type = str_replace('image/', '', $_FILES['photo']['type']);

          $fileName = $_FILES['photo']['name'];
          $tmpName  = $_FILES['photo']['tmp_name'];
          $fileSize = $_FILES['photo']['size'];
          $fileType = $_FILES['photo']['type'];

          $fp      = fopen($tmpName, 'r');
          $content = fread($fp, filesize($tmpName));
          $content = addslashes($content);
          fclose($fp);

          // Query to insert the info into the table Picture
          $sql = "INSERT INTO Picture
                  SET
                    userID = '{$id}',
                    ext = '{$type}',
                    data = '{$content}'";

          $stmt = $db->prepare($sql);
          $stmt->execute();
          // Gets the ID of the inserted picture
          $picID = $db->lastInsertId();

          // Updates the user's info with the id of the picture
          $sql = "UPDATE User
                  SET
                    profilePicture = '{$picID}'
                  WHERE userID = '{$id}'";

            $stmt = $db->prepare($sql);
            $stmt->execute();
        }
        else{
            // Default photo

        }
    }

    // If the user pressed the Login button
    else {
        // Query to get the user's info according to the username and password provided
        $password = md5 ( $_POST['password'] );
        $sql = "SELECT 
                    userID,
                    userName,
                    password
                FROM User
                WHERE userName = '{$_POST['username']}'
                AND password = '{$password}';
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        // If a matching user was found set loggedin to true, and get the user's ID
        if(count($result) > 0) {
            $loggedin = true;
            $id = $result[0]['userID'];
        }
    }
}

// Set a cookie for maintaining the session with the user. Expires in a day.
if($loggedin) { 
    setcookie('loggedin', $id, time() + (86400 * 7)); // 86400 = 1 day
    header('Location: index.php');
    return;
}
?>