<?php

function generatePage($body, $title="Students Connect") {
    $page = <<<EOPAGE
<!doctype html>
<html>
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>$title</title>	
    </head>
            
    <body>
            $body
    </body>
</html>
EOPAGE;
    return $page;
}

function generatePageMac($body, $title="Students Connect", $styleSheetName="login.css") {
    $page = <<<EOPAGE
<!doctype html>
<html>
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="$styleSheetName" />
        <title>$title</title>	
    </head>
            
    <body>
            $body
    </body>
</html>
EOPAGE;
    return $page;
}


function generatePageWithTop($bodyBottom, $title="Students Connect", $styleSheetName="") {
    global $host, $user, $password, $database;
    session_start();
    
    $db = connectToDB($host, $user, $password, $database);
	
	if ($db->connect_error) {
		die($db->connect_error);
	} else {
		//$body .= "db connection established";
	}
    
    $student="";
    $body="";
    
    if (isset($_SESSION['username'])){
        $student = $_SESSION['username'];
    } else {
        $student = "gerket";
    }
    
    $query = "select * from users where username=\"$student\"";
    $result = $db->query($query);
    
    if (!$result) {
			die("User Profile Retrieval failed: ". $db->error);
		} else {
		/* Number of rows found */
			$num_rows = $result->num_rows;
			if ($num_rows === 0) {
				$body .= "You Are Not Registered In The DB!!<br />";
			} else {
				
				//left side message board button
				$body.="<img alt='Students Connect' src='books.jpg' height=100px width=100px onclick='window.location.href='mainClassSelection.php';' />";
				//$body.="<div align='center'>$title</div>";
				//right hand table with username and logout and pic
				$body .= "<table align='right'><tbody>";
				for ($row_index = 0; $row_index < $num_rows; $row_index++) {
					$result->data_seek($row_index);
					$row = $result->fetch_array(MYSQLI_ASSOC);
                    $pic = $row['pic'];
                    
                    	
					$body.= "<tr><td rowspan=2><img alt='User Image' height=60px width=60px src=\"data:image/jpeg;base64,'.base64_encode($pic).'\"/></td><td>Welcome, <a href='userProfile.php'>$student</a>!</td></tr>";
                    $body.= "<tr><td align='center'><button value='Log out' >Log out</button></td></tr>";
					//echo "Name: {$row['name']}, Id: {$row['id']} <br>";
				}
				$body .= "</tbody></table>";
			}
		}
    
    $page = <<<EOPAGE
            $body <br /><br />
            <hr/>
            $bodyBottom
EOPAGE;
    session_destroy();
	
	if ($styleSheetName === "")
		return generatePage($page,$title);
	else
		return generatePageMac($page,$title,$styleSheetName);
}

?>