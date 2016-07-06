<?php
	$host = "127.0.0.1";
	$user = "root";
	$password = "";
	$database = "groupProject";
	
	$db = connectToDB($host, $user, $password, $database);
	
	$sqlQuery = "";
	echo mysqli_query($db, "drop table messages");
	echo mysqli_query($db, "drop table userClasses");
	echo mysqli_query($db, "drop table users");
	echo mysqli_query($db, "drop table classes");
	echo ": 4 dropped tables<br />";
	
	$sqlQuery = "create table messages (class varchar(8), id int, username varchar(25), message text, fileName varchar(20), fileMimeType varchar(512), fileData longblob)";
	echo mysqli_query($db, $sqlQuery);
	echo ": 1 created table messages<br />";
	
	//which classes the user is in
	$sqlQuery = "create table userClasses (username varchar(25), class varchar(8))";
	echo mysqli_query($db, $sqlQuery);
	
	$sqlQuery = "insert into userClasses values ('gerket', 'CMSC389N')";
	echo mysqli_query($db, $sqlQuery);
	
	$sqlQuery = "insert into userClasses values ('gerket', 'CMSC420')";
	echo mysqli_query($db, $sqlQuery);
	echo ": 3 table userClasses<br />";
	
	//user table creation and initialization
	$sqlQuery = "create table users (username varchar(25), firstname varchar(25), lastname varchar(25), bio text, pic longblob, password varchar(25))";
	echo mysqli_query($db, $sqlQuery);
	
	$sqlQuery = "insert into users values ('gerket', 'Tom', 'Gerke', 'I am a senior in Computer Science!', NULL, 'password')";
	echo mysqli_query($db, $sqlQuery);
	echo ": 2 table users<br />";
	
	//classes table creation and initial values
	$sqlQuery = "create table classes (class varchar(10))";
	echo mysqli_query($db, $sqlQuery);
	

	$sqlQuery = "insert into classes (class) values ('CMSC389N')";
	echo mysqli_query($db, $sqlQuery);
	
	$sqlQuery = "insert into classes (class) values ('CMSC420')";
	echo mysqli_query($db, $sqlQuery);
	echo ": 3 table classes<br />";
	
	mysqli_close($db);

function connectToDB($host, $user, $password, $database) {
	$db = mysqli_connect($host, $user, $password, $database);
	if (mysqli_connect_errno()) {
		echo "Connect failed.\n".mysqli_connect_error();
		exit();
	}
	return $db;
}
?>