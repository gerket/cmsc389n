<!doctype html>
<html>
    <head> 
        <meta charset=UTF-8" /> 
		<title>CMSC420</title>
        <link rel="stylesheet" href="classPage.css" />
		<script src="classPage.js"></script>
	</head>
</html>

<?php
	require_once("support.php");
	session_start();

	$scriptName = $_SERVER["PHP_SELF"];
	$topPart = <<<EOBODY
		<form action="$scriptName" method="post">
			<h1><u>CMSC420/u></h1> 
            <br/>

            <h3><strong>Message successfully posted! </strong></h3>

			<p id = "backbutton"> <input type=button onClick="parent.location='CMSC420.php'" value='Go back'> </p>
		</form>		
EOBODY;

	$page = generatePage($topPart);

	echo $page;
?>