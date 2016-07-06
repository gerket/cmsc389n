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
    
    $user="";
    $body="";
    
    if (isset($_SESSION['user'])){
        $user = $_SESSION['user'];
    } else {
        $user = "gerket";
    }
    
    $query = "select * from users where username=\"$user\"";
    $result = $db->query($query);
    
    if (!$result) {
			die("User Profile Retrieval failed: ". $db->error);
		} else {
		/* Number of rows found */
			$num_rows = $result->num_rows;
			if ($num_rows === 0) {
				$body .= "You Are Not Registered In The DB!!<br />";
			} else {
				$body .= "<table align='right'><tbody>";
				for ($row_index = 0; $row_index < $num_rows; $row_index++) {
					$result->data_seek($row_index);
					$row = $result->fetch_array(MYSQLI_ASSOC);
                    $pic = $row['pic'];
                    
                    	
					$body.= "<tr><td rowspan=2><img alt='User Image' height=60px width=60px src=\"data:image/jpeg;base64,'.base64_encode($pic).'\"/></td><td>Welcome, $user!</td></tr>";
                    $body.= "<tr><td align='center'><button value='Log out' >Log out</button></td></tr>";
					//echo "Name: {$row['name']}, Id: {$row['id']} <br>";
				}
				$body .= "</tbody></table>";
			}
		}
    
    $page = <<<EOPAGE
            $body <br /><br /><br /><br />
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