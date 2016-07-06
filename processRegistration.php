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
//	$imagename=$_POST["pic"]["name"]; 
//    $pic=addslashes (file_get_contents($_POST['pic']['tmp_name']));
	//$pic = $_POST['pic'];

     // need 2 queries for userclasses and users
     foreach ($_POST['classType'] as $key){
        //value("username", "key")
        $query1 = "insert into userclasses values(\"".($username).("\", \"").($key).("\")");
        $result = $db_connection->query($query1);
        if (!$result) {
            die("Insertion failed: " . $db_connection->error);
        }    
    }
    $query2 = "insert into users values(\"".($username).("\", \"").($firstname).("\", \"").($lastname).("\", \"").($bio).("\", NULL, \"").($password).("\")");
    $result2 = $db_connection->query($query2);
	
	//$query3 = sprintf("update users set pic='%s' where username='%s'",$pic,$username);
	//$result3 = $db_connection->query($query3);
	
    if (!$result2) {
        die("Insertion failed: " . $db_connection->error);
    } else {
        print "here";
        $_SESSION['username'] = $username;
        header("Location: mainClassSelection.php");
    }
<<<<<<< HEAD
=======
    //session_destroy();
>>>>>>> refs/remotes/origin/bringingTogether
?>