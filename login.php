<?php
	require_once("support.php");
	require_once("dbLogin.php");
	session_start();
//	$host = "localhost";
//    $user = "root";
//    $password = "";
//    $database = "groupproject";
//	/* Connecting to the database */		
	$db_connection = connectToDB($host, $user, $password, $database);//new mysqli($host, $user, $password, $database);
	if ($db_connection->connect_error) {
		die($db_connection->connect_error);
	}
	
	$scriptName = "";
	$body = "";
	
	if (isset($_POST["submit"])) {
		$nameValue = trim($_POST["name"]);
		$passwordValue = $_POST["password"];
		
		$query = "SELECT password FROM users WHERE username='".($nameValue).("'");
		$result = $db_connection->query($query);
		$passval = $result->fetch_assoc();
		print ($passwordValue).("<br />");
		print ($passval["password"]).("WOW<br />");
			
		if ($nameValue === "" || $passwordValue === "" || $passval["password"] === "" || $passval["password"] !== $passwordValue){ 
			$body .= "<br /><strong>Invalid login information provided.</strong><br />";
            $passwordValue = "";
            $nameValue = "";
            $scriptName = $_SERVER["PHP_SELF"];
		}else if (!$result) {
			die("Retrieval failed: " . $db_connection->error);
			$body .= "<br /><strong>Invalid login information provided.</strong><br />";
            $passwordValue = "";
            $nameValue = "";
            $scriptName = $_SERVER["PHP_SELF"];
		} 
		if ($body == "") {
			$_SESSION["username"] = $nameValue;
            header("Location: mainClassSelection.php");
		}
	} else {
		$nameValue = "";
		$passwordValue = "";
	}
	
	// superglobals are not accessible in heredoc
    $scriptName = $_SERVER["PHP_SELF"];
	$topPart = <<<EOBODY
		<form action="$scriptName" method="post">
			<img src="books.jpg" alt="books.jpg" id="books" style="width:500px;height:228px;">
            <h1><u>CS Class Discussion</u></h1>
			<h2>Login</h2>
			<div id="general">
				<strong>Username: </strong><input type="text" name="name" value="$nameValue" /><br /><br />
				<strong>Password: </strong><input type="password" name="password" value="$passwordValue"/><br /><br />
				<input type="submit" name="submit" value="Login" />&nbsp;
				<input type="button" name="register" value="Register" onClick="document.location.href='register.php';" />
			</div>
		</form>		
EOBODY;
	$body = $topPart.$body;
	
	$page = generatePageMac($body,NULL,"login.css");
	echo $page;
	//session_destroy();
?>