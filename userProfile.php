
<?php
	
	require_once("support.php");
	require_once ("dbLogin.php"); 
	$flagged = 0;
	$found = 0;
	$classes = array();
	$scriptName = $_SERVER["PHP_SELF"];
	$username;
	$bio;
	$pic;
	
	session_start();
	
	
	if (isset($_SESSION["username"])) {
		
		$username = trim($_SESSION["username"]);
	} else {
		$username = "gerket";
	}
	
		//$expiration = time() + 3600; /* one hour from now */
		//$path = "/"; /* a cookie should be sent for any page within the server environment */
		//$domain = "";  /* adjust with appropriate domain name */
		//$sentOnlyOverSecureConnection = 0; /* 1 for secure connection */
		//setcookie("username",$username, $expiration, $path, $domain, $sentOnlyOverSecureConnection);
		//setcookie("gamer", $passwordValue, $expiration, $path, $domain, $sentOnlyOverSecureConnection);
			
		
		
		
		$db_connection = connectToDB($host, $user, $password, $database);//new mysqli($host, $user, $password, $database);
		if ($db_connection->connect_error) {
			die($db_connection->connect_error);
		}
		
		/* Query */
		$query = "select * from users";
				
		/* Executing query */
		$result = $db_connection->query($query);
		if (!$result) {
			die("Retrieval failed: ". $db_connection->error);
		} else {
			/* Number of rows found */
			$num_rows = $result->num_rows;
			if ($num_rows === 0) {
				echo "Empty Table<br>";
			} else {
				for ($row_index = 0; $row_index < $num_rows; $row_index++) {
					$result->data_seek($row_index);
					$row = $result->fetch_array(MYSQLI_ASSOC);
									
					 if( $row['username']  == $username ){//&& $row['password'] === $passwordValue
						//$found = 1;
						//$username =  trim($row['username']);		
						$bio = $row['bio'];
						$pic = $row['pic'];							
					 }

				}
			}
		}

		/* Freeing memory */
		$result->close();
		
		/* Closing connection */
		$db_connection->close();
		
		$db_connection = connectToDB($host, $user, $password, $database);//new mysqli($host, $user, $password, $database);
		if ($db_connection->connect_error) {
			die($db_connection->connect_error);
		} 
		
		/* Query */
		$query = "select * from userClasses";
				
		/* Executing query */
		$result = $db_connection->query($query);
		if (!$result) {
			die("Retrieval failed: ". $db_connection->error);
		} else {
			/* Number of rows found */
			$num_rows = $result->num_rows;
			if ($num_rows === 0) {
				echo "Empty Table<br>";
			} else {
				for ($row_index = 0; $row_index < $num_rows; $row_index++) {
					$result->data_seek($row_index);
					$row = $result->fetch_array(MYSQLI_ASSOC);
									
					 if( $row['username']  == $username){
						$found = 1;
						array_push($classes,$row['class']);
					 }					
				}
			}
		}
		
		/* Freeing memory */
		$result->close();
		
		/* Closing connection */
		$db_connection->close();


		if($found == 1){
		//print "<h1>User Profile</h1></br>";
		$scriptName = $_SERVER["PHP_SELF"];
		$body ="";
		
		$body.= "<h1>User Profile</h1></br>";
		$body.= '<table border= "1">';
		
		//$body .= "<tr>";
		//$body .= "<td>";
		//$body .= '<center><input type="submit"  value = "MessageBoard" name = "return"/></center>';
		//$body .= "</td>";
		//$body.=  '</tr>';
		
		$body .= "<tr>";
		
		
		$body.= "<td align='center'><br/>";
		
		$body .= '<img align="center" src="data:image/jpeg;base64,'.base64_encode($pic).'" height="300"/></td></tr><tr><td></br></br>';
		$body .= "<strong>Username: </strong>$username</br><br/>";
		$body .= " <strong>My Classes: </strong>";
		$body .= "<ul>";
		
		foreach($classes as $class1){
			
			$body.= "<li>";
			$body.= "$class1";
			$body.= "</li>";
			
		}
		
		$body .= "</ul>";
		$body .= "<strong>Bio: </strong>$bio</br></br>";
	
		$body.= '<form action="userProfile.php"method="post">';
		$body.= '<center><input type="submit"  value= "Update My Profile" name= "update"/><br/></center>';
		$body.= "</form>";
		
		$body .= "</td>";
	
		$body.=  '</tr>';
	
		$body.= "</table>";
	
		//$page = generatePageWithTop($body);
		//echo $page;

		}else{
			print "<p>No entry exists in the database for the specified username and password</p>";
		}
	//} //huge if statement session username
	
	if (isset($_POST["update"])) {
		header("Location:updateProfile.php");
		}

//	if($found == 0){
//		 $scriptName = $_SERVER["PHP_SELF"];
//		$body = <<<EOBODY
//		  
//			<form action="$scriptName" method="post">
//			<H1>Login In</H1>
//			<p><strong>Username:</strong><input type="text" name="username" /><br/>
//		    <p><strong>Password: </strong><input type="password" name="passwordValue" /><br/>
//				
//				
//				
//			</p>
//			
//          
//		<input type="submit" name ="submitdata" /><br/>
//		</form>
//		<form action="$scriptName" method="post">
//		</p>
//		</form>
//	
//			
//EOBODY;
//		$page = generatePage($body);
//		echo $page;	
//	}
	
	//session_destroy();
	$page = generatePageWithTop($body);
		echo $page;
	exit();     
?>