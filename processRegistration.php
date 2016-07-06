<?php
    session_start();
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "groupproject";
	/* Connecting to the database */		
	$db_connection = new mysqli($host, $user, $password, $database);
	if ($db_connection->connect_error) {
		die($db_connection->connect_error);
	}
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $username = trim($_POST['uname']);
    $bio = $_POST['bio'];

     // need 2 queries for userclasses and users
     foreach ($_POST['classType'] as $key){
        //value("username", "key")
        $query1 = "insert into userclasses values(\"".($username).("\", \"").($key).("\")");
        $result = $db_connection->query($query1);
        if (!$result) {
            die("Insertion failed: " . $db_connection->error);
        }    
    }
    $query2 = "insert into users values(\"".($username).("\", \"").($firstname).("\", \"").($lastname).("\", \"").($bio).("\", null, \"").($password).("\")");
    $result2 = $db_connection->query($query2);
    if (!$result2) {
        die("Insertion failed: " . $db_connection->error);
    } else {
        print "here";
        $_SESSION['user'] = $username;
        header("Location: login.php");
    }
    session_destroy();
?>