<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" /> 
		<title>User Registration</title>
        <link rel="stylesheet" href="register.css" />
        <script src="register.js"></script>
    </head>
    <body>
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
		?>
        <h1><u>User Registration</u></h1>  <br /><br />
            <form action="processRegistration.php" method="post">
                <div id="general">
                Firstname: <input type="text" name="firstname" id="firstname" />
                Lastname: <input type="text" name="lastname" id="lastname" /><br /><br />
                UID:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="uid" id="uid" style="width:10em" /><br /><br />
                Username:  <input type="text" name="uname" id="uname" /><br /><br />
                Password:&nbsp;&nbsp;<input type="password" name="password" id="pass" /><br /><br />
                Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="email" name="email" id="email" size="30" />
                <br />
                </div><br />
                <div id="misc">
                    <h3>Courses</h3>
                    Which courses are you currently taking? (select all that apply)<br /><br />
                        <select name="classType[]" multiple="multiple">
							<?php
								$query = "SELECT class FROM classes";
								$result = $db_connection->query($query);
								
								if (!$result) {
									die("Retrieval failed: " . $db_connection->error);
								} else {
									while($row = $result->fetch_assoc()){
										echo "<option value=\"".($row["class"]).("\">").($row["class"]).("</option>");
									}
								}
							?>
                        </select>
                    <br />
                    <h3>Bio</h3>
                    <textarea name="bio" id="bio" style="height:100px; width:500px"></textarea>
                   
                </div><br />
                <div id="submission">
                    <input type="reset" value="Clear Form" />
                    <input type="submit" value="Submit Form" />
                </div>
            </form>
        
    </body>
</html>