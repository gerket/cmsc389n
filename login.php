<?php
	require_once("support.php");
	
	$scriptName = "";
	$body = "";
	if (isset($_POST["submit"])) {
		$nameValue = trim($_POST["name"]);
		$passwordValue = trim($_POST["password"]);
		
		if ($nameValue === "" || ($nameValue !== "cmsc298s") || $passwordValue === "" || ($passwordValue !== "terps")) 
			$body .= "<br /><strong>Invalid login information provided.</strong><br />";
            $passwordValue = "";
            $nameValue = "";
            $scriptName = $_SERVER["PHP_SELF"];
		if ($body == "") {
            header("Location: main.php");
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
	
	$page = generatePage($body);
	echo $page;
?>