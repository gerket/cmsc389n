

<?php
    require_once("support.php");
	require_once("dbLogin.php");
    session_start();
	
	
	
	$styleSheet = "classPage.css";
    $body = "";
    $mtable = "";
    $newid;

	if(isset($_SESSION['currClass'])){
		$title = $_SESSION['currClass'];
	} else {
		$title = "CMSC420";
	}
	
	//if(isset($_SESSION['username'])){
		$username = $_SESSION['username'];

    //$host = "127.0.0.1";
    //$user = "root";
    //$password = "";
    //$database = "groupproject";

    $db = connectToDB($host, $user, $password, $database);

    $query = "select * from messages where class = '$title'"; 
    

    $result = $db->query($query);
   

    if (!$result) {
        die("Retrieval failed: ". $db->error);
    } 
    else {
        $numberOfRows = mysqli_num_rows($result);

        if ($numberOfRows == 0) {
            $mtable = "<h2>No messages in this discussion</h2>";

        } 
        else {
            $newid = $numberOfRows ;//+ 1;
            $mtable .= "<table align='center' border='1' cellpadding='40' width='1000'>";

            while ($mArray = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $id = $mArray['id'];
                $usernameM = $mArray['username'];
                $message = $mArray['message'];
				
				$q2 = "select username,pic from users where username='$usernameM'";
				$r2 = $db->query($q2);
				$row = $r2->fetch_array(MYSQLI_ASSOC);
                $pic = $row['pic'];
                $realPic = base64_encode($pic);
				
				$mtable.="<tr ><td align='center'>Message #$id<br/><br/>";
				$mtable.= "<table><tr><td numrows=2><img alt='User Image' height=80px  src=\"data:image/jpeg;base64,$realPic\"/></td>";
                $mtable .= " <td>$usernameM</td></tr></table></td>" . "<td align='center'><br/>$message<br/></td></tr>"; 
            }
            $mtable .= "</table>";
        }
    }

    $result->close();


    if(isset($_POST["submitbutton"])) {
        $curruser = $_SESSION['username']; //may need to change based on what the session var is actually stored as 
        $currclass = $title;
        //$ftype = $_FILES['filename']['type'];

        $poop = $_POST["yourmessage"];

        //$sqlQuery = sprintf("insert into messages (class, id, username, message, fileName, fileMimeType, fileData) values (%s, %d, %s, %s, %s,%s,%s)", 
                     //$currclass, $newid, $curruser, $poop, "NULL", "NULL", "NULL"); //filedata????????????????

        $sqlq = "insert into messages values(\"".($currclass).("\", \"").($newid).("\", \"").($curruser).("\", \"").($poop).("\", null").(", null").(", null").(")");



        $res = $db->query($sqlq);


        if(!$res) {
            die("insert failed: " . $db->error);
        }
        mysqli_close($db);

        //send username and message to database

        $_SESSION["blob"] = $sqlQuery;



        header("Location: submitmessage420.php");
    } 
    else {
        $themessage = "";
        $fname = NULL;
    }

    $scriptName = $_SERVER["PHP_SELF"];
    $topPart = <<<EOBODY
        <form action="$scriptName" method="post">
            <h1><u>$title</u></h1> 
            <br/>

            $mtable
            <br/><br/>

            <textarea name="yourmessage" value="$themessage" rows="8" cols="100"></textarea> 
            <br/>

            <br/>
        
            <p id = "fsbuttons"> 
                <input type="file" name="filename" value="$fname"/> 
                <input type="submit" name="submitbutton" value="Submit"/> 
            </p>
        </form>
EOBODY;

    $body = $topPart.$body; 
    
    $page = generatePageWithTop($body,$title,$styleSheet);

    echo $page;        
?>