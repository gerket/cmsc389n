
<?php
	require_once("support.php");
	require_once("dbLogin.php");
	session_start();

	$scriptName = $_SERVER["PHP_SELF"];
	$topPart = <<<EOBODY
		<form action="$scriptName" method="post">
			<h1><u>CMSC389N</u></h1> 
            <br/>

            <h3><strong>Message successfully posted! </strong></h3>

			<p id = "backbutton"> <input type=button onClick="parent.location='CMSC420.php'" value='Back To Class Page'> </p>
		</form>		
EOBODY;

	$page = generatePageWithTop($topPart,"CMSC420","classPage.css");

	echo $page;
?>