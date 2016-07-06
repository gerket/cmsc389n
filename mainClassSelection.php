<?php
	require_once("dbLogin.php");
	require_once("support.php");
	
	session_start();
	
	$db = connectToDB($host, $user, $password, $database);
	$body = "";
	$title = "Course Webpages";
	
	if ($db->connect_error) {
		die($db->connect_error);
	} else {
		//$body .= "db connection established";
	}
	
	$student;
	
	if( isset($_SESSION["username"]) ){
		$student = $_SESSION["username"];
	} else {
		$student = "gerket";
	}
	
	//print $_SESSION["username"];//testing username grab
		
		$query = sprintf("select * from userclasses where username='%s'", $student);
		$result = $db->query($query);
		
		
		if (!$result) {
			die("User Class Retrieval failed: ". $db->error);
		} else {
		/* Number of rows found */
			$num_rows = $result->num_rows;
			if ($num_rows === 0) {
				$body .= "You Are Not Enrolled In Any Classes!<br />";
			} else {
				$body.="<h1>Course Webpages</h1><br/>";
				//$body .= "<form action=''>";
				for ($row_index = 0; $row_index < $num_rows; $row_index++) {
					$result->data_seek($row_index);
					$row = $result->fetch_array(MYSQLI_ASSOC);
					$class = $row['class'];
					$body.= "<a id='classLinks' href='{$class}.php'>$class Webpage </a><br /><br />";
					//echo "Name: {$row['name']}, Id: {$row['id']} <br>";
				}
				//$body .= "</form>";
			}
		}
		

	
	
	//session_destroy();
	echo generatePageWithTop($body,$title,"mainClassSelection.css");
	
function referenceToPage($classTo){
	$_SESSION['currClass'] = $classTo;
	header("Location: CMSC389N.php");

}
?>