<?php
	    session_start();
	    require_once("support.php");
	    require_once ("dbLogin.php");
	    $classes = array();
	    $classType = array();
	    $classCheck ="";
       
      
		
       	
	$db_connection = connectToDB($host, $user, $password, $database);//new mysqli($host, $user, $password, $database);
	if ($db_connection->connect_error) {
		die($db_connection->connect_error);
	} 
	
	/* Query */
	$query = "select * from users where username=\"{$_SESSION['username']}\"";
			
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
				
				 //if( $row['username']  == $_COOKIE['username'] && $row['password']  === $_COOKIE['gamer']){;
	 
                                  $username =   trim($row['username']);
	                          $firstname = trim($row['firstname']);
	                          $lastname =  trim($row['lastname']);
	                          $bio  =      trim($row['bio']);
	                         
				
				// }
					
				 }
				
				
				
				
				
			}
		}
	
	
	/* Freeing memory */
	$result->close();
	
	///* Closing connection */
	//$db_connection->close();
	//	
	//      
	//
	//$db_connection = new mysqli($host, $user, $password, $database);
	//if ($db_connection->connect_error) {
	//	die($db_connection->connect_error);
	//} 
	
	/* Query */
	$query = "select * from classes";
			
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
				$i = 0;
				$result->data_seek($row_index);
				$row = $result->fetch_array(MYSQLI_ASSOC);
				
				 $classCheck .= sprintf('<strong>%s</strong><input type="checkbox" name="%s" value="%s">',$row['class'],$i,$row['class']);
                                 array_push($classes,$row['class']);
				
	                 	  $i++;
				 }	
			}
		}
	
	
	/* Freeing memory */
	$result->close();
	
	/* Closing connection */
	$db_connection->close();
		
       
     
     if (isset($_POST["update"])) {
     

	$imagename=$_FILES["pic"]["name"]; 
	$pic=addslashes (file_get_contents($_FILES['pic']['tmp_name']));

	$lastname = trim($_POST["firstname"]);
	$firstname = trim($_POST["lastname"]);
	$nameValue = trim($_POST["name"]);
	$bio = trim($_POST["bio"]);
	$old = $_SESSION["username"];
	
	
	if(isset($_POST["0"])){
		array_push($classType,$_POST["0"]);
	}
	
	if(isset($_POST["1"])){
		array_push($classType,$_POST["1"]);
	}
	
	if(isset($_POST["2"])){
	   array_push($classType,$_POST["2"]);	
	}
	
	
	
	/* Connecting to the database */		
	$db_connection = new mysqli($host, $user, $password, $database);
	if ($db_connection->connect_error) {
		die($db_connection->connect_error);
	} 
	
	/* Query */
    $query = sprintf("update users set firstname='%s',lastname='%s',username='%s',bio=\"%s\",pic='%s' where username='%s'",$firstname,$lastname,$nameValue,$bio,$pic,$old);

			
			
	/* Executing query */
	$result = $db_connection->query($query);
	if (!$result) {
		die("Insertion failed: " . $db_connection->error);
	}
	
//	/* Closing connection */
//	$db_connection->close();
//    
//    
//    $db_connection = new mysqli($host, $user, $password, $database);
//	if ($db_connection->connect_error) {
//		die($db_connection->connect_error);
//	} 
	
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
				 				
				 if( $row['username']  == $nameValue ){
					$found = 1;
					
					$pic = $row['pic'];
				 }
			}
		}
	}
	
	
	
	/* Connecting to the database */		
	$db_connection = new mysqli($host, $user, $password, $database);
	if ($db_connection->connect_error) {
		die($db_connection->connect_error);
	} 
	
	foreach ($classType as $key){
        //value("username", "key")
        $query1 = "insert into userclasses values(\"".($username).("\", \"").($key).("\")");
        $result = $db_connection->query($query1);
        if (!$result) {
            die("Insertion failed: " . $db_connection->error);
        }    
    }
	
	/* Closing connection */
	$db_connection->close();
	
	
	
	
	
	
	
	$scriptName = $_SERVER["PHP_SELF"];
    	
	$body ="";
	

	$body.= '<table border= "1">';
	
	//$body .= "<tr>";
	//$body .= "<td>";
	//$body .= '<center><input type="submit"  value = "MessageBoard" name = "return"/></center>';
	//$body .= "</td>";
	//$body.=  '</tr>';
	
	$body .= "<tr>";
	
	
	$body.= "<td>";
	
	$body .= '<img src="data:image/jpeg;base64,'.base64_encode($pic).'" height="300"/></br></br>';
	$body .= "<strong>Username: </strong>$nameValue</br>";
	$body.= "<h1>Your Profile Has Been Updated!</h1>";
	$body .= "</td>";
	$body.=  '</tr>';
	
	$body.="<tr><td><center><input type='button' value='Back to Profile' onclick=\"window.location.href='userProfile.php';\" /></center></td></tr>";	

 
	$body.= "</table>";
		




$page = generatePageWithTop($body);
echo $page;
	
     
     }else{
        
         //<tr>
         //   <td>
         // <center>  <input type="submit"  value = "Message Board" name = "update"/></center>
         //   </td>
         //   
         //   </tr>
		
        $body = <<<EOBODY
        
        
    
        <H1>Update Profile!</H1>
		<table border="1">
           
           
			<form action="updateProfile.php" method="post" enctype="multipart/form-data">
           
            
		<tr>
        <td>
	    <strong> Username: </strong><input type="text" name="name" value="$username" /></br>
            <strong>Firstname: </strong><input type="text" name="firstname" value="$firstname" />
	    <strong>Lastname: </strong><input type="text" name="lastname"  value="$lastname" /><br/><br/>
          
		$classCheck
		</br></br>
	 
	 
            <strong>Bio: </strong><input type="textfield" name= "bio" value="$bio" /><br/><br/>
               <strong>Profile Picture<input type="file" name="pic" size="25" /><br/><br/>
           
            
     
        
		
		<center><input type="submit"  value = "submit" name = "update"/></center>
		</p>
		</form>
           </td>
        </tr>
	</table>
    
			
EOBODY;

echo generatePageWithTop($body);
        
exit();
        
        
     }
     
        
        


