<?php
	require_once("support.php");
	require_once ("dbLogin.php");
	session_start();
	
	$db = new mysqli($host, $user, $password, $database);
	$body = "";
	
	if ($db->connect_error) {
		die($db->connect_error);
	} else {
		//$body .= "db connection established";
	}
	
	$user;
	
	if( isset($_SESSION["user"]) ){
		$user = $_SESSION["user"];
	} else {
		$user = "gerket";
	}
		
		$query = sprintf("select * from userclasses where username='%s'", $user);
		$result = $db->query($query);
		
		
		if (!$result) {
			die("User Class Retrieval failed: ". $db->error);
		} else {
		/* Number of rows found */
			$num_rows = $result->num_rows;
			if ($num_rows === 0) {
				$body .= "You Are Not Enrolled In Any Classes!<br />";
			} else {
				$body .= "<form action=''>";
				for ($row_index = 0; $row_index < $num_rows; $row_index++) {
					$result->data_seek($row_index);
					$row = $result->fetch_array(MYSQLI_ASSOC);
					$class = $row['class'];
					$body.= "<a  href='{$class}.php'>$class Webpage </a><br /><br />";
					//echo "Name: {$row['name']}, Id: {$row['id']} <br>";
				}
				$body .= "</form>";
			}
		}
		
	
	
	
	session_destroy();
	echo generatePageWithTop($body);
?>